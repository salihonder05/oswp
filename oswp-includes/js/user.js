"use strict";
exports.__esModule = true;
exports.User = void 0;
var User // class ismi hatasına aldanma. js dosyayı çalışıyor.
 = /** @class */ (function () {
    function User() {
    }
    /**
     * With Usage JS User Find Location And Usage navigator.geolocation.getCurrentPosition() Function
     * @function callback
     * @function error
     * @returns { object }
     */
    User.prototype.findUserLocation = function () {
        navigator.geolocation.getCurrentPosition(function callback(position) {
            var getCoord = position.coords;
            console.log({
                latitude: getCoord.latitude,
                longitude: getCoord.longitude,
                altitude: getCoord.altitude,
                speed: getCoord.speed,
                heading: getCoord.heading,
                accuracy: getCoord.accuracy,
                altitude_accuracy: getCoord.altitudeAccuracy,
                // use position variable
                timestamp: position.timestamp
            });
            return {
                latitude: getCoord.latitude,
                longitude: getCoord.longitude,
                altitude: getCoord.altitude,
                speed: getCoord.speed,
                heading: getCoord.heading,
                accuracy: getCoord.accuracy,
                altitude_accuracy: getCoord.altitudeAccuracy,
                // use position variable
                timestamp: position.timestamp
            };
        }, function error(err) {
            console.log("Navigator GeoLocation Not Supported. Error: ".concat(err.message));
            throw new Error("Navigator GeoLocation Not Supported");
        });
    };
    /**
     * With Usage Js Find User Page Link.
     * Note:
     *  - Bu Fonskiyon Çıktısı Sayfa Kaynağını Görüntüle Kısmında Gözükmez
     *    Sadece İncele'den görebilirsin. (tr)
     *  - This Function Input Can't Displayed View Page Source (en)
     * @param {boolean} find
     * @returns
     */
    User.prototype.findUserPage = function (find) {
        if (find === void 0) { find = true; }
        if (typeof find !== 'boolean') {
            console.log('Parameter Only Be Boolean');
            return null;
        }
        if (find === true) {
            var createHiddenInput = document.createElement('input');
            createHiddenInput.type = 'hidden';
            createHiddenInput.name = 'oswp_find_page';
            createHiddenInput.value = String(window.document.location); // get link path
            createHiddenInput.id = 'oswp_find_page';
            createHiddenInput.className = 'oswp_find_page';
            document.body.appendChild(createHiddenInput);
        }
    };
    User.prototype.windowController = function (changeTitle) {
        if (typeof changeTitle !== "string") {
            console.log('changeTitle Not String!');
            return false;
        }
        var defaultTitle = document.title;
        window.addEventListener('blur', function () {
            document.title = changeTitle;
        });
        window.addEventListener('focus', function () {
            document.title = defaultTitle;
        });
    };
    User.prototype.windowClose = function (message) {
        var decision = confirm(message);
        if (decision === true) {
            window.close();
        }
    };
    /**
     * if userAgent Empty close window
     * @param auto automatic start?
     */
    User.prototype.checkUserAgent = function (auto) {
        if (auto === void 0) { auto = true; }
        if (typeof auto !== "boolean") {
            throw new TypeError('Just Boolean');
        }
        if (auto !== true) {
            return false;
        }
        if (navigator.userAgent == ' ' ||
            navigator.userAgent == '') {
            window.close();
        }
    };
    return User;
}());
exports.User = User;
window.addEventListener('load', function () {
    var user = new User();
    user.findUserPage(true);
});
