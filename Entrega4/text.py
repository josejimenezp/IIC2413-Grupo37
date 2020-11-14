from flask import Flask, request, json
from pymongo import MongoClient


# Local  ###  localhost:5000/
app = Flask(__name__)

# MONGODATABASE = "test"
# MONGOSERVER = "localhost"
# MONGOPORT = 27017
# client = MongoClient(MONGOSERVER, MONGOPORT)

# db = client[MONGODATABASE]

USER = 'grupo37'
PASS = 'grupo37'
DATABASE = 'grupo37'

URL = f"mongodb://{USER}:{PASS}@gray.ing.puc.cl/{DATABASE}?authSource=admin"
client = MongoClient(URL)

# Nombre BD
db = client["grupo37"]


@app.route("/text-search")
def text_search():
    try:
        content = json.loads(request.data)
    except:
        content = {}

    desired = content.get('desired')
    required = content.get('required')
    forbidden = content.get('forbidden')
    uid = content.get('userId')

    search = ""
    palabras_prohibidas = []

    if desired:
        for d in desired:
            search += f"{d} "
    if required:
        for r in required:
            search += f"\"{r}\" "
    if forbidden:
        for f in forbidden:
            
            # Si se trata de una frase
            if " " in f:
                search += f"-\"{f}\" "
                # palabras_prohibidas.append(f"\"{f}\"")
            else:
                search += f"-{f} "
                # palabras_prohibidas.append(f"{f}")
            palabras_prohibidas.append(f"\"{f}\"")

    print(search)
    print(palabras_prohibidas)

    # Si recibo id de usuario y una búsqueda
    if uid and search:
        print("id y search")

        # Si solo tiene criterios de exclusión
        if forbidden and not(desired) and not(required):
            print("forbidden")

            # Busco los mensajes que si tengan las palabras no deseadas y extraigo sus mid's
            mid_prohibidos = []

            for frase in palabras_prohibidas:
                mensajes_prohibidos = list(
                    db.mensajes.find(
                        {"$text": {"$search": frase}},
                        {"_id": 0}
                    )
                )

                json.jsonify(mensajes_prohibidos)

                # Construyo una lista solo con los ids de los mensajes que quiero omitir
                for mensaje in mensajes_prohibidos:

                    # Si no se encuentra en la lista lo agrego
                    if mensaje['mid'] not in mid_prohibidos:
                        mid_prohibidos.append(mensaje['mid'])

            # Busco los mensajes con 'sender' == uid y que no se encuentren dentro de los mensajes prohibidos
            resultados = list(
                db.mensajes.find(
                    {"mid": {"$nin": mid_prohibidos}, 'sender': uid},
                    {"_id": 0}
                )
            )

        else:
            resultados = list(
                db.mensajes.find(
                    {"$text": {"$search": search}, 'sender': uid},
                    {"_id": 0, "score": {"$meta": "textScore"}}
                )
                .sort( [ ("score", {"$meta": "textScore"}) ] )
            )
    
    # Si solo recibo una búsqueda
    elif search:
        print("solo search")

        # Si solo tiene criterios de exclusión
        if forbidden and not(desired) and not(required):
            print("forbidden")

            # Busco los mensajes que si tengan las palabras no deseadas y extraigo sus mid's
            mid_prohibidos = []

            for frase in palabras_prohibidas:
                mensajes_prohibidos = list(
                    db.mensajes.find(
                        {"$text": {"$search": frase}},
                        {"_id": 0}
                    )
                )
                print(frase)
                print('Mensajes:\n' + str(mensajes_prohibidos))

                json.jsonify(mensajes_prohibidos)

                # Construyo una lista solo con los ids de los mensajes que quiero omitir
                for mensaje in mensajes_prohibidos:

                    # Si no se encuentra en la lista lo agrego
                    if mensaje['mid'] not in mid_prohibidos:
                        mid_prohibidos.append(mensaje['mid'])
            
            print(mid_prohibidos)

            # Busco los mensajes con 'sender' == uid y que no se encuentren dentro de los mensajes prohibidos
            resultados = list(
                db.mensajes.find(
                    {"mid": {"$nin": mid_prohibidos}},
                    {"_id": 0}
                )
            )

        else:
            resultados = list(
                db.mensajes.find(
                    {"$text": {"$search": search}},
                    {"_id": 0, "score": {"$meta": "textScore"}}
                )
                .sort( [ ("score", {"$meta": "textScore"}) ] )
            )
    
    # Si solo recibo un id de usuario
    elif uid:
        print("solo id")
        resultados = list(
            db.mensajes.find(
                {'sender': uid},
                {"_id": 0}
            )
        )
    
    # Si no recibo nada
    else:
        print("nada")
        resultados = list(db.mensajes.find({}, {"_id": 0}))


    return json.jsonify(resultados)



if __name__ == "__main__":
    app.run(debug=True)
