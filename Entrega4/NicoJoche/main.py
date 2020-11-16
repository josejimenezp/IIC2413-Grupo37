from flask import Flask, json, request
from pymongo import MongoClient
app = Flask(__name__)

MONGODATABASE = "test"
MONGOSERVER = "localhost"
MONGOPORT = 27017
client = MongoClient(MONGOSERVER, MONGOPORT)
db = client[MONGODATABASE]
user_keys_msg = ['message','sender','receptant','lat','long','date']
#DELETE
@app.route("/message/<int:id_>", methods=['DELETE'])
def delete(id_):
    result = list(db.mensajes.find({"mid":id_}))
    if len(result) != 0:
        delete = db.mensajes.remove({'mid':id_})
        return "<h1>Mensaje eliminado<h1>"
    else:
        return {"mensaje": "El mensaje no pudo ser eliminado porque no existe"}

#POST
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
        sender = list(db.mensajes.find({"sender":data['sender']},{"_id":0}))
        receptant = list(db.mensajes.find({"receptant":data['receptant']},{"_id":0}))

        if len(sender) != 0 and len(receptant) != 0:
            result = db.mensajes.insert(data)
            mensaje = "Mensaje enviado"
            return {"message":data["message"], 'sender':data["sender"], 'receptant':data['receptant'],'lat':data['lat'],'long':data['long'],'date':data['date']}
        else:
            mensaje = "No se pudo enviar el mensaje"
            return {"mensaje":mensaje}
    else:
        return {"mensaje": f"El mensaje no se pudo enviar, falta{faltante}"}

if __name__ == "__main__":
    app.run(debug=True)
