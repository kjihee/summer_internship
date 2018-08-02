import os
from apistar import App, Route


BASE_DIR = os.path.dirname(__file__)
TEMPLATE_DIR = os.path.join(BASE_DIR, 'templates')


def welcome(app: App, name=None):
    return app.render_template('index.php', name=name)

routes = [
    Route('/', method='GET', handler=welcome),
]

app = App(routes=routes, template_dir=TEMPLATE_DIR)


if __name__ == '__main__':
    app.serve('192.168.10.190', 5000, use_debugger=True)


