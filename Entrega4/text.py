from flask import Flask, request, json
from pymongo import MongoClient


# Local  ###  localhost:5000/
app = Flask(__name__)

MONGODATABASE = "test"
MONGOSERVER = "localhost"
MONGOPORT = 27017
client = MongoClient(MONGOSERVER, MONGOPORT)
db = client[MONGODATABASE]


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
    if desired:
        for d in desired:
            search += f"{d} "
    if required:
        for r in required:
            search += f"\"{r}\" "
    if forbidden:
        for f in forbidden:
            search += f"-{f} "

    if uid and search:
        print("id y search")
        resultados = list(db.mensajes.find({"$text": {"$search":search}, 'sender': uid}, {"_id": 0}))
    elif search:
        print("solo search")
        resultados = list(db.mensajes.find({"$text": {"$search":search}}, {"_id": 0}))
    elif uid:
        print("solo id")
        resultados = list(db.mensajes.find({'sender': uid}, {"_id": 0}))
    else:
        print("nada")
        resultados = []

    print(search)

    return json.jsonify(resultados)



if __name__ == "__main__":
    app.run(debug=True)
