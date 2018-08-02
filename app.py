from flask import Flask
from flask import request
from apistar import App, Route

app = Flask(__name__)

@app.route('/', methods=['GET','POST'])
def upload_file():
 if request.method == 'POST':
   file = request.files['file1'];
   print(file.filename)
   return file.filename  


if __name__ == '__main__':
    app.serve('127.0.0.1', 5000 ,debug=True)
