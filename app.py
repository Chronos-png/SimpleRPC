from flask import Flask, render_template, request, jsonify
import xmlrpc.client

app = Flask(__name__)

@app.route('/', methods=['GET', 'POST'])
def index():
    result = None
    if request.method == 'POST':
        # Ambil data dari form
        a = int(request.form.get('a', 0))
        b = int(request.form.get('b', 0))
        c = int(request.form.get('c', 0))
        
        # Buat client XML-RPC
        server_url = 'http://192.168.137.204:8000'
        server = xmlrpc.client.ServerProxy(server_url)

        try:
            # Kirim request XML-RPC
            result = server.PrediksiGender(a, b, c)
        except Exception as e:
            result = f"Error: {e}"

    return render_template('index.html', result=result)

if __name__ == '__main__':
    app.run(debug=True)
