class User // class ismi hatasına aldanma. js dosyayı çalışıyor.
{
    constructor() 
    {
    }

    /**
     * Console Screen Message
     */
    consoleScreenMessage( message: string , css: string)
    {
        if( typeof message !== "string" )
        {
            throw new TypeError( 'Message Parameter Not String' );
        }

        if( typeof css !== "string" )
        {
            throw new TypeError( 'CSS Parameter Not String' );
        }

        console.log(
            '%c'+ String( message ) , String( css )
        );
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
            return document.body.appendChild(createHiddenInput);
        }
    }

    /**
     * Client Different To Go Page Change Default Title
     * @param {string} changeTitle  Change Title String
     * @returns 
     */
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

    /**
     * Client Close Window 
     * @param message Close Message
     */
    windowClose( message: string ): void
    {
        var decision = confirm( message );
        if( decision === true )
        {
            window.close();
        }
    }

    /**
     * if userAgent Empty close window
     * @param {boolean} auto automatic start?
     */
    checkUserAgent( auto: boolean = true )
    {
        if( typeof auto !== "boolean" )
        {
            throw new TypeError( 'Just Boolean' );
        }

        if( auto !== true )
        {
            return false;
        }

        if( 
            navigator.userAgent == ' ' ||
            navigator.userAgent == '' 
        ){
            window.close();
        }
    }

    /**
     * Have Script Tags Add Defer Attribute
     * @param {boolean} auto  Add auto All Script Tag Defer Attribute
     * @returns 
     */
    addDefer( auto: boolean = true )
    {
        if( typeof auto !== 'boolean' )
        {
            throw new TypeError( 'Just Boolean' );
        }
        
        if( auto === false )
        {
            return false;
        }

        let getEl = document.getElementsByTagName('script');
        for( var i in getEl )
        {
            if( !getEl[i].defer )
            {
                getEl[i].defer = true;
            }
        }
    }

    /**
     * With Enter Tag Name Add _blank 
     * @param {string} el   Enter Tag Name 
     */
    addTargetBlank( el: string = 'a')
    {
        if( 
            typeof el != "string" && 
            el != "" && 
            el != ' '
        ){
            throw new Error( 'Element Not String And Empty' );
        }

        let getEl = document.getElementsByTagName( el );
        for( var i in getEl )
        {
            if( !getEl[i].target )
            {
                getEl[i].target = '_blank';
            }
        }
    }

}

window.addEventListener( 'load' , () => {
    let user = new User();

    /**
     * Console Screen Message
     */
    user.consoleScreenMessage(
        'No Script!',
        'color: red; background-color: darkred; font-size: 30px; padding: 10px;'
    );

    user.findUserPage( true );

    user.addTargetBlank('a');
});