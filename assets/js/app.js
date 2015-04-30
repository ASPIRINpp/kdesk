var App = new function() {
    var instance;

    // Приватные методы и свойства
    // ...

    // Конструктор
    function Singleton() {
        if ( !instance )
            instance = this;
        else return instance;

        // Публичные свойства
    }

    // Публичные методы
    Singleton.prototype.test = function() {};

    return Singleton;
}

window.app = new App;