from flask import Flask, request, json
from pymongo import MongoClient


# Local  ###  localhost:5000/
app = Flask(__name__)

MONGODATABASE = "test"
MONGOSERVER = "localhost"
MONGOPORT = 27017
client = MongoClient(MONGOSERVER, MONGOPORT)
db = client[MONGODATABASE]


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
                "receptant": {"$in": [int(id1), int(id2)]}}
            ]
        }
    else:
        filtro = {}

    mensajes = list(db.mensajes.find(filtro, {"_id": 0}))
    return json.jsonify(mensajes)


@app.route("/messages/<int:id1>")
def get_user_messages(id1):

    mensajes = list(db.mensajes.find({"$or": [{"sender": id1}, {"receptant": id1}]}, {"_id": 0}))
    return json.jsonify(mensajes)


if __name__ == "__main__":
    app.run(debug=True)
