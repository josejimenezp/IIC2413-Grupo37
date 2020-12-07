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

# ---------------------- HOME -------------------------------
@app.route("/")
def home():
	'''
	Página de inicio
	'''
	return "<h1>Hello World!</h1>"

# ---------------------- Fin HOME -------------------------------

# ------------------------ Users --------------------------------
@app.route("/users")
def getUsers():
	users = list(db.usuarios.find({}, {"_id": 0}))
	return json.jsonify(users)

# ---------------------- Fin Users -------------------------------

# ----------------------- Get User -------------------------------
@app.route("/users/<int:uid>")
def getUser(uid):
	user = list(db.usuarios.find({"uid":uid}, {"_id": 0}))
	user_messages = list(db.mensajes.find({"sender":uid}, {"_id": 0}))
	response = user
	response.extend(user_messages)

	if response == []:
		return 'No existe este usuario :('

	return json.jsonify(response)

# ---------------------- Fin Get User -------------------------------

# ---------------------- Get Messages -------------------------------
@app.route("/messages/")
def get_messages():
	# messages/
	# messages?id1=<id1>&id2=<id2>
	id1 = request.args.get('id1')
	id2 = request.args.get('id2')

	if not (id1 is None or id2 is None):
		filtro = {
			"$and":[
				{"sender": {"$in": [int(id1), int(id2)]},
				"receptant": {"$in": [int(id1), int(id2)]}
				}
			]
		}
	else:
		filtro = {}

	mensajes = list(db.mensajes.find(filtro, {"_id": 0}))

	if mensajes == []:
		return 'No existen mensajes con estas características :('
	
	return json.jsonify(mensajes)
# ---------------------- Fin Get Messages -------------------------------

# ------------------------ Get Message ----------------------------------
@app.route("/messages/")
def get_messages1():
    name = request.args.get('name')

    if not (name is None):
        id_mongo = list(db.usuarios.find({'name':name},{'_id':0,'uid':1}))
        return json.jsonify(id_mongo)
        #mensajes_recibidos = list(db.usuarios.find({'name':name},{'_id':0}))




def get_message(id1):

	mensajes = list(db.mensajes.find({"mid": int(id1)}, {"_id": 0}))

	if mensajes == []:
		return 'No existen mensajes con estas características :('

	return json.jsonify(mensajes)
# ---------------------- Fin Get Message -------------------------------

# ---------------------- Get Message -----------------------------------
@app.route("/messages/")

user_keys_msg = ['message','sender','receptant','lat','long','date']

# ------------------------ DELETE --------------------------------------
@app.route("/message/<int:id_>", methods=['DELETE'])
def delete(id_):
    result = list(db.mensajes.find({"mid":id_}))
    if len(result) != 0:
        delete = db.mensajes.remove({'mid':id_})
        return "Mensaje eliminado"
    else:
        return {"mensaje": "El mensaje no pudo ser eliminado porque no existe"}
# ---------------------- Fin DELETE ---------------------------------

# ----------------------- POST --------------------------------------
@app.route("/messages", methods=['POST'])
def post_messages():
    categorias = request.json.keys()
    faltante = ""
    for categoria in user_keys_msg:
        if categoria not in categorias:
            faltante += f" {categoria}"
    
    if faltante == "":
        data = {key: request.json[key] for key in user_keys_msg} 
        mid = db.mensajes.count_documents({}) + 1
        data['mid'] = mid 
        sender = db.usuarios.find({"uid":data['sender']},{"_id":0})
        receptant = db.usuarios.find({"uid":data['receptant']},{"_id":0})

        if sender and receptant:
            result = db.mensajes.insert(data)
            mensaje = "Mensaje enviado"
            return {"message":data["message"], 'sender':data["sender"], 'receptant':data['receptant'],'lat':data['lat'],'long':data['long'],'date':data['date']}
        else:
            mensaje = "No se pudo enviar el mensaje"
            return {"mensaje":mensaje}
    else:
        return {"mensaje": f"El mensaje no se pudo enviar, falta{faltante}"}
# ---------------------- Fin POST -----------------------------------

# ----------------------- Text-Search -------------------------------
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
    palabras_deseadas = []

    if desired:
        for d in desired:
            search += f"{d} "
            palabras_deseadas.append(f"\"{d}\"")
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

    # Si recibo id de usuario y una búsqueda
    if uid and search:
        print("id y search")

        # Si solo tiene criterios de exclusión
        if forbidden and not(desired) and not(required):

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
                ).sort( [("mid", 1)] )
            )

        # Si solo hay palabras deseadas
        elif desired and not(forbidden) and not(required):
            
            # Busco los mensajes que tengan las palabras deseadas y extraigo sus mid's
            mid_deseados = []

            for palabra_d in palabras_deseadas:
                mensajes_deseados = list(
                    db.mensajes.find(
                        {"$text": {"$search": palabra_d}},
                        {"_id": 0}
                    )
                )

                json.jsonify(mensajes_deseados)

                # Construyo una lista solo con los ids de los mensajes
                for mensaje in mensajes_deseados:
                    # Si no se encuentra en la lista lo agrego
                    if mensaje['mid'] not in mid_deseados:
                        mid_deseados.append(mensaje['mid'])
            
            # Busco los mensajes con 'sender' == uid y que se encuentren dentro de los mensajes deseados
            resultados = list(
                db.mensajes.find(
                    {"mid": {"$in": mid_deseados}, 'sender': uid},
                    {"_id": 0}
                ).sort( [("mid", 1)] )
            )

        else:
            resultados = list(
                db.mensajes.find(
                    {"$text": {"$search": search}, 'sender': uid},
                    {"_id": 0, "score": {"$meta": "textScore"}}
                )
                .sort( [ ("score", {"$meta": "textScore"}), ("mid", 1) ] )
            )
    
    # Si solo recibo una búsqueda
    elif search:
        print("solo search")

        # Si solo tiene criterios de exclusión
        if forbidden and not(desired) and not(required):

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

            # Busco los mensajes que no se encuentren dentro de los mensajes prohibidos
            resultados = list(
                db.mensajes.find(
                    {"mid": {"$nin": mid_prohibidos}},
                    {"_id": 0}
                ).sort( [("mid", 1)] )
            )
        
        # Si solo hay palabras deseadas
        elif desired and not(forbidden) and not(required):
            
            # Busco los mensajes que tengan las palabras deseadas y extraigo sus mid's
            mid_deseados = []

            for palabra_d in palabras_deseadas:
                mensajes_deseados = list(
                    db.mensajes.find(
                        {"$text": {"$search": palabra_d}},
                        {"_id": 0}
                    )
                )

                json.jsonify(mensajes_deseados)

                # Construyo una lista solo con los ids de los mensajes
                for mensaje in mensajes_deseados:
                    # Si no se encuentra en la lista lo agrego
                    if mensaje['mid'] not in mid_deseados:
                        mid_deseados.append(mensaje['mid'])
            
            # Busco los mensajes que se encuentren dentro de los mensajes deseados
            resultados = list(
                db.mensajes.find(
                    {"mid": {"$in": mid_deseados}},
                    {"_id": 0}
                ).sort( [("mid", 1)] )
            )

        else:
            resultados = list(
                db.mensajes.find(
                    {"$text": {"$search": search}},
                    {"_id": 0, "score": {"$meta": "textScore"}}
                )
                .sort( [ ("score", {"$meta": "textScore"}), ("mid", 1) ] )
            )
    
    # Si solo recibo un id de usuario
    elif uid:
        print("solo id")
        resultados = list(
            db.mensajes.find(
                {'sender': uid},
                {"_id": 0}
            ).sort( [("mid", 1)] )
        )
    
    # Si no recibo nada
    else:
        resultados = list(db.mensajes.find({}, {"_id": 0}).sort( [("mid", 1)] ))


    if resultados == []:
        return 'No hay conincidencias!'

    return json.jsonify(resultados)

# ---------------------- Fin Text-Search -------------------------------


if __name__ == "__main__":
    app.run(debug=True)
