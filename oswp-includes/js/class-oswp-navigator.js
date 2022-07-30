class OSWP_User
{
    constructor()
    {
    }

    /**
     * With Usage JS User Find Location And Usage navigator.geolocation.getCurrentPosition() Function
     * @function callback
     * @function error
     * @returns { object }
     */
    findUserLocation() 
    {
        navigator.geolocation.getCurrentPosition( 
            function callback( position ) {
                var getCoord = position.coords;
                console.log({ 
                    'enlem'  : getCoord.latitude,
                    'boylam' : getCoord.longitude,
                    'yükseklik' : getCoord.altitude,
                    'hız'       : getCoord.speed,
                    'rota'  : getCoord.heading,
                    'accuracy' : getCoord.accuracy,
                    'altitude_accuracy' : getCoord.altitudeAccuracy,

                    // use position variable
                    'zaman' : position.timestamp,
                });

                return {
                    'enlem'  : getCoord.latitude,
                    'boylam' : getCoord.longitude,
                    'yükseklik' : getCoord.altitude,
                    'hız'       : getCoord.speed,
                    'rota'  : getCoord.heading,
                    'accuracy' : getCoord.accuracy,
                    'altitude_accuracy' : getCoord.altitudeAccuracy,

                    // use position variable
                    'zaman' : position.timestamp,
                }
            }
            ,
            function error( err ) 
            {
                console.log( `Navigator GeoLocation Not Supported. Error: ${err.message}` );
                return false;
            }
        );
    }

    /**
     * With Usage Js Find User Page Link.
     * Note: 
     *  - Bu Fonskiyon Çıktısı Sayfa Kaynağını Görüntüle Kısmında Gözükmez
     *    Sadece İncele'den görebilirsin. (tr)
     *  - This Function Input Can't Displayed View Page Source (en)
     * @param {boolean} find 
     * @returns 
     */
    findUserPage( find = true )
    {
        if( typeof find !== 'boolean' )
        {
            console.log( 'Parameter Only Be Boolean' );
            return null;
        }

        if( find === true )
        {
            var createHiddenInput = document.createElement('input');
            createHiddenInput.type = 'hidden';
            createHiddenInput.name = 'oswp_'+ this.findUserPage.name +'_find_page';
            createHiddenInput.value = window.document.location; // get link path
            createHiddenInput.id = 'oswp_'+ this.findUserPage.name +'_find_page';
            createHiddenInput.className = 'oswp_'+ this.findUserPage.name +'_find_page';
            createHiddenInput.readOnly = true;
            document.body.appendChild(createHiddenInput);
        }
    }

    windowController( changeTitle )
    {
        if( typeof changeTitle !== "string" )
        {
            console.log( 'changeTitle Not String!' );
            return false;
        }

        var defaultTitle = document.title;
        window.addEventListener( 'blur' , () => {
            document.title = changeTitle;
        });

        window.addEventListener( 'focus' , () => {
             document.title = defaultTitle;
        });
    }

    windowClose( message )
    {
        var decision = confirm( message );
        if( decision === true )
        {
            window.close();
        }
    }
}

window.addEventListener( 'load' , () => {
    var oswp_user = new OSWP_User();
    //oswp_navigator.findUserLocation();
    oswp_user.findUserPage(true);
});

