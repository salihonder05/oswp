class User // class ismi hatasına aldanma. js dosyayı çalışıyor.
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
    findUserLocation() : void 
    {
        navigator.geolocation.getCurrentPosition(
            function callback( position ) {
                var getCoord = position.coords;
                console.log({
                    latitude          : getCoord.latitude,
                    longitude         : getCoord.longitude,
                    altitude          : getCoord.altitude,
                    speed             : getCoord.speed,
                    heading           : getCoord.heading,
                    accuracy          : getCoord.accuracy,
                    altitude_accuracy : getCoord.altitudeAccuracy,

                    // use position variable
                    timestamp : position.timestamp,
                });

                return {
                    latitude          : getCoord.latitude,
                    longitude         : getCoord.longitude,
                    altitude          : getCoord.altitude,
                    speed             : getCoord.speed,
                    heading           : getCoord.heading,
                    accuracy          : getCoord.accuracy,
                    altitude_accuracy : getCoord.altitudeAccuracy,

                    // use position variable
                    timestamp : position.timestamp,
                }
            }
            ,
            function error( err ) {
                console.log( `Navigator GeoLocation Not Supported. Error: ${err.message}` );
                throw new Error( `Navigator GeoLocation Not Supported` );
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
    findUserPage( find: boolean = true )
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
            createHiddenInput.name = 'oswp_find_page';
            createHiddenInput.value = String( window.document.location ); // get link path
            createHiddenInput.id = 'oswp_find_page';
            createHiddenInput.className = 'oswp_find_page';
            document.body.appendChild(createHiddenInput);
        }
    }

    windowController( changeTitle: string )
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

    windowClose( message: string )
    {
        var decision = confirm( message );
        if( decision === true )
        {
            window.close();
        }
    }

}

window.addEventListener( 'load' , () => {
    let user = new User();
    user.findUserPage( true );
});