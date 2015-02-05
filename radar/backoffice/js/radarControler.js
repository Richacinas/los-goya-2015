  function replaceAll( text, busca, reemplaza ) {
    while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca,reemplaza);
    return text;
  }


  var radarControler = {

    settings: { // radarControler.settings
      filesListFile:    '../../data/timeline.json',
      filesListFile2:   '../../data/stream-favorites/timeline.json',
      FolderFinalFiles: '../../radar/final/',
      FolderDataFiles:  '../../data/',
      FolderDataFiles2: '../../data/stream-favorites/',
      twtprocessor:     '../../app/twtprocess.php',
      termsFile:        '../../data/properties/searchTerms.json'
    },
        // otros 
    data: { // radarControler.data:
      user: [],
      processed: { // almacenando los datos de cada minuto
        live: [],
        api: []
      },
      totals: {},
      queries:{   // almacenamos los archivos de timelines
        live: [],
        api: []
      },
      totals: [], // los datos que ya se muestran al usuario
      numElementosSearch: 0,
      tagCount: {} // contamos los tags de los elementos del totals
    },
    cache: { // radarControler.cache -> asignamos los elementos luego
      $timeline: $('#bl-data'), // er tooltip 
      $sidebar: $('#bl-sidebar-list'), // er tooltip <
      $sidebarStream: $('#bl-sidebar-list-stream'), // er tooltip 
      tplWrap: '<div class="twt-list"><h2></h2><div class="twt-wrap clearfix"></div></div>',
      tplImg: '<div class="ui-state-default twt-elm twt-elm-img">\
                  <div class="tag clearfix">\
                    <div class="fa" style="float:left; margin-top: 8px;">\
                      <div class="fa fa-stop" style="color:white; display:none;"></div>\
                      <div class="fa fa-windows" style="color:white; display:none;"></div>\
                      <div class="fa fa-plus" style="color:white; display:none;"></div>\
                    </div>\
                    <span></span>\
                    <a href="#" class="wipeout"><i class="fa fa-times"></i></a>\
                    <a href="#" class="muestra-grande"><i class="fa fa-stop"></i></a>\
                    <a href="#" class="muestra-chico"><i class="fa fa-windows"></i></a>\
                    <a href="#" class="limpia-tweet"><i class="fa fa-times"></i></a>\
                  </div>\
                  <h3></h3>\
                  <div class="links"><a target="_blank" href="" class="usr"></a>\
                  <a target="_blank" href="" class="lnk">ver post</a></div>\
                  <img src=""><div></a>\
                <div>',
      tplTwet: '<div class="twt-elm">\
                  <div class="tag clearfix">\
                    <div class="fa" style="float:left; margin-top: 8px;">\
                      <div class="fa fa-stop" style="color:white; display:none"></div>\
                      <div class="fa fa-windows" style="color:white; display:none"></div>\
                      <div class="fa fa-plus" style="color:white; display:none"></div>\
                    </div>\
                    <span></span>\
                    <a href="#" class="wipeout"><i class="fa fa-times"></i></a>\
                    <a href="#" class="muestra-texto"><i class="fa fa-plus"></i></a>\
                    <a href="#" class="limpia-tweet"><i class="fa fa-times"></i></a>\
                  </div>\
                  <h3></h3>\
                  <div class="links"><a target="_blank" href="" class="usr"></a>\
                  <a target="_blank" href="" class="lnk">ver post</a></div>\
                <div>'
    },

    // radarControler.start
    start: function() {
      radarControler.queryList();
      radarControler.bindevents();

      radarControler.menu.init();
      radarControler.streaming.init();
      radarControler.searchTerms.init();     
      radarControler.movingItems(); 

      setInterval(radarControler.queryList, 20000);
    },
    streaming: { // radarControler.streaming

      // radarControler.streaming.init()
      init: function() {

        // Gestion de los eventos
        // ------------------------------------------------------------

        $("#muestra-config").click(function(){

          $('.bl-sidebar-bl-act').removeClass('bl-sidebar-bl-act');

          // Cambiamos la clase
          $this = $(this);
          $i = $("i", $this);

          if ( $i.hasClass("fa-minus") ) {

            $i.removeClass("fa-minus");
            $i.addClass("fa-plus");

            $(".config-wrap", $("#config-streaming")).addClass("config-elm-disable");

          } else {

            $i.addClass("fa-minus");
            $i.removeClass("fa-plus");

            $(".config-wrap", $("#config-streaming")).removeClass("config-elm-disable");

          }
        });

        $("#cleanDataButton").on("click", function() {
          // Show clean confirmation
          radarControler.streaming.showCleanConfirmationPopup();
          return false;
        });

      },
      showCleanConfirmationPopup: function() {
        $("#cleanDataPopup").fadeIn("fast", function() {
          $("#cleanDataReject").on("click", function(){
            $("#cleanDataPopup").fadeOut("fast");
          });
        });
      },
      // radarControler.streaming.reiniciarEvento()      
      reiniciarEvento: function() {


        if ( confirm("¿Estas seguro que quieres reiniciar el evento?")) {

          var url           = radarControler.settings.twtprocessor + "?method=wipeout";
          var token         = $('#csrf_token').val();

          // Realizamos el metodo POST pasandole el JSON con los datos
          $.post(url, {token: token}, function(data) {  
            
            console.log("Reiniciando");
            $('#bl-sidebar-list, #bl-sidebar-list-stream').html('');
            radarControler.data = {
              user: [],
              processed: { // almacenando los datos de cada minuto
                live: [],
                api: []
              },
              totals: {},
              queries:{   // almacenamos los archivos de timelines
                live: [],
                api: []
              },
              totals: [], // los datos que ya se muestran al usuario
              numElementosSearch: 0
            };

            $("#mensajeStreaming").html("Reiniciando evento");
          });
        }
      },
      // radarControler.streaming.iniciarEvento()
      iniciarEvento: function() {

      },      
      // radarControler.streaming.finalizarEvento()         
      finalizarEvento: function() {

      },      
    },
    menu: { // radarControler.menu

      // radarControler.menu.init()
      init: function() {

        $("#settings").click(function(){
          
          radarControler.clearRightBar();
          $(this).parents('.bl-sidebar-bl').addClass('bl-sidebar-bl-act')
          $("#config-list").removeClass("config-elm-disable");
          $("#settings").html("Ocultar configuracion");
          //$("#config-streaming").removeClass("config-elm-disable");
          $("#settings").html("Ocultar configuracion");

        });

        $("#streaming").click(function(){
          radarControler.clearRightBar();
          $(this).parents('.bl-sidebar-bl').addClass('bl-sidebar-bl-act')
          radarControler.drawStreaming(true);

        });
      }
    },
    searchTerms: { // radarControler.searchTerms

      // radarControler.searchTerms.init()
      init: function() {


        radarControler.searchTerms.generateTagListInput();

        radarControler.searchTerms.submitEvent();


        $("#muestra-tags").click(function(){

          // Cambiamos la clase
          $this = $(this);
          $i = $("i", $this);

          if ( $i.hasClass("fa-minus") ) {

            $i.removeClass("fa-minus");
            $i.addClass("fa-plus");

            $(".config-wrap", $("#config-list")).addClass("config-elm-disable");

          } else {

            $i.addClass("fa-minus");
            $i.removeClass("fa-plus");

            $(".config-wrap", $("#config-list")).removeClass("config-elm-disable");

          }         
        });

      },
      // radarControler.searchTerms.submitEvent()    
      submitEvent: function() {

        // Gestion de los eventos
        // ------------------------------------------------------------

        // Enviar los datos del formulario si son correctos
        $( "#dataForm" ).submit(function( event ) {
         
          // Stop form from submitting normally
          event.preventDefault();
         
          $("#mensajeTags").html("");

          // Get some values from elements on the page:
          var form          = $(this);
          var tags          = $("input[name=tags]",form).val();
          var search        = $('input[name^="search"]');
          var filter        = $('input[name^="filter"]');
          var token         = $('#csrf_token').val();

          var url           = form.attr("action");

          // Generamos la cadena JSON que se pasa al fichero que procesa los datos
          var searchString  = '[';
          var filterString  = '[';
          var counterString  = '[';

          var i;

          for ( i = 0; i < search.length - 1; i++ ) {

            searchString = searchString + '"' + search[i].value + '", ';

            if ( $(filter[i]).is(':checked') ) {  
              filterString = filterString + '"true", ';  
            } else {  
              filterString = filterString + '"false", ';   
            }

          }

          searchString = searchString + '"' + search[i].value + '"]';

          if ( $(filter[i]).is(':checked') ) {  
            filterString = filterString + '"true"]';  
          } else {  
            filterString = filterString + '"false"]';  
          }          

          // Realizamos el metodo POST pasandole el JSON con los datos
          $.post(url, {tags:tags, search: searchString, filter: filterString, token: token}, function(data) {
            console.log("done");
            $("#mensajeTags").html("Cambios realizados");
          });
        });

      },

      // radarControler.searchTerms.anyadirTerminoBusqueda()      
      anyadirTerminoBusqueda: function (){

        $(".search-input").append('<input id="filter['+radarControler.data.numElementosSearch+']" type="checkbox" name="filter['+radarControler.data.numElementosSearch+']" value="" class="check">\n<input id="search['+radarControler.data.numElementosSearch+']" type="text" name="search['+radarControler.data.numElementosSearch+']" value="" class="search">\n');
        
        radarControler.data.numElementosSearch++;

        return false;
      },
      generateTagListInput: function() {

        // Inicializacion

        $.getJSON( radarControler.settings.termsFile )
          .done(function( json ) {
            
            //console.log( "JSON Leido: ");

            var tags          = "";
            var tagsString    = "";
            var searchs       = "";
            var filter        = "";
          
            $.each(json["tags"], function(posicion, elemento){

              // Recorremos el JSON y mostramos los elementos que lo componen
              tags = tags + "#" + elemento + ", ";
              tagsString = tagsString + elemento + ", ";         
            });

            // Eliminamos la ultima ", "
            tags = tags.substring(0, tags.lastIndexOf(", "));
            tagsString = replaceAll(tags, "#", "");


            // Añadimos los tags al imput correspondiente
            $(".tags-input").html(tags);

            $(".tags-input").append('<input type="hidden" name="tags" value="'+tagsString+'"><br />');

                // select para el insertador de posts
            var $select = $("#tag-select");
            $select.find('option').remove();
            $select.append('<option value="-1">Untagged</option>');

            json["search"].sort(function SortByName(a, b){
              var aName = a.toLowerCase();
              var bName = b.toLowerCase(); 
              return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
            });

            $.each(json["search"], function(posicion, elemento){

              $select.append('<option value="'+posicion+'">'+elemento.split(',')[0]+'</option>');

              // Recorremos el JSON y mostramos los elementos que lo componen
              var checked = ""; 
              if ( json["filter"][radarControler.data.numElementosSearch] === "true") {
                checked = "checked";
              } else if ( json["filter"][radarControler.data.numElementosSearch] === "false") {
                checked = "";
              } else {
                checked = "";
              }

              $(".search-input").append('<input id="filter['+radarControler.data.numElementosSearch+']" type="checkbox" name="filter['+radarControler.data.numElementosSearch+']" '+ checked + ' value="'+elemento+'" class="check">\n<input id="search['+radarControler.data.numElementosSearch+']" type="text" name="search['+radarControler.data.numElementosSearch+']" value="'+elemento+'"  class="search input-'+elemento.split(',')[0].replace(/ /g,"_")+'">\n');

              radarControler.data.numElementosSearch++;
            });
            
            radarControler.searchTerms.drawTermsCount()

          })
          .fail(function( jqxhr, textStatus, error ) {
            
            var err = textStatus + ", " + error;
            console.log( "Error al leer el JSON: " + err );
        });      
      },
      drawTermsCount: function(){
        
        $input = $(".search-input");
        $input.find('.count').remove();
        
        for(element in radarControler.data.tagCount){
        
          if(radarControler.data.tagCount.hasOwnProperty(element)){
            var $target = $input.find('.input-'+element.replace(/ /g,"_").replace(/@/g,""));
            if($target.length) $('<span class="count">'+radarControler.data.tagCount[element]+'</span>').insertBefore($target);
          }
        }
      }
    },       
    bindevents: function(){
          // eventos en elementos del listado
      $('#bl-data')
        .delegate('.muestra-grande, .muestra-chico, .muestra-texto, .limpia-tweet, .wipeout', 'click', function(e){
          var $this = $(this);
          var $wrap = $this.parents('.twt-elm');
          var $page = $this.parents('.twt-list');
          var queryType = $page.data('type');
          var data = $wrap.data();
          var datos = '';
          var query = '';
          var id = '';
          var time = ''; 



          if(queryType != "total"){ // para los que no son tweets del streaming
            datos = radarControler.data.processed[queryType][data.time]['search'][data.elm];
            datos.userData = radarControler.data.user[datos['user']];
            query = data.query;
            time = data.time;
          } 

          id = data['twetId'];

          var method;

          if($this.hasClass('muestra-grande')){
            method = 'add-big';
          } else if($this.hasClass('muestra-chico')){
            method = 'add-small';
          } else if($this.hasClass('muestra-texto')){
            method = 'add-text';
          } else if($this.hasClass('limpia-tweet')){
            method = 'delete';
          } else if($this.hasClass('wipeout')){
            method = 'delete';
          }
          var token = $('#csrf_token').val();

          var request = $.ajax({
            timeout: 10000,
            type: "GET",
            url: radarControler.settings.twtprocessor,
            data: {
              'method'  : method,
              'json'    : JSON.stringify(datos),
              'tag'     : query,
              'time'    : time,
              'id'      : id,
              'token'   : token
            },                        
          }).done( function(data, status) {
              if (method = 'delete' && $wrap.hasClass('twt-wipe') && status === "success"){
                $wrap.remove();
              } else {
                $wrap.toggleClass('twt-elm-disable');
                datos.disabled = true;
              }
              return data;
          }).fail( function(request, status, error) {

            console.log('request: ' + request);

            if ( request.responseText != "done"){              
              console.log('request.responseText: ' + request.responseText);                           
            }

            console.log('status: ' + status);
            console.log('error: ' + error); 

            return false;
          });

          return false;
        })

          // eventos en elementos del sidebar
      $('#bl-sidebar-list, #bl-sidebar-list-stream')
        .delegate('.bl-list-elm a', 'click', function(e){
          var $this = $(this);
          var time = $this.parents('.bl-list-elm').data('time');

          radarControler.clearRightBar();
          $this.addClass('act').parents('.bl-sidebar-bl').addClass('bl-sidebar-bl-act');

          if($this.hasClass('live-tw')){
            radarControler.drawMinute(time, 'live-tw');
          } else if($this.hasClass('tw-api')){
            radarControler.drawMinute(time, 'tw-api');
          }

          return false;
        });

      $('.bl-sidebar-postlink a').bind('click', function(){
        var $this = $(this), type, tag, $textarea = $('#paste-url');

        var link = $textarea.val().replace(/(\r\n|\n|\r)/gm,"").trim();
        if (link.length == 0) {
          $textarea.addClass('error');
          return false;
        }
        if($this.hasClass('add-grande')){
          type = 'img-big';
        } else if($this.hasClass('add-chico')){
          type = 'img-small';
        } else { // asumimos 'add-texto'
          type = 'txt';
        }

          // vemos si se ha marcado algun tag
        if ( $('#tag-select').val() != -1 ) {
          tag = $('#tag-select').find('option:selected').html().split(',')[0];
        } else {
          tag = '';
        }

        // Guardamos el objeto para el procesamiento posterior
        var $that   = $("#paste-url");
        // También se guarda el token para comprobación en destino
        var token   = $('#csrf_token').val();

        // Procesamos la url
        $.ajax( radarControler.settings.twtprocessor, {
          data: {
            'method'    : 'check',
            'link'      : link,
            'type'      : type,
            'tag'       : tag,
            'token'     : token
            
          },
          success: function(data, status){
            console.log(data);

            if(data === 'error'){
              $that.addClass('error');
            } else {
              $that.removeClass('error');
              $that.val('').attr('placeholder', 'Envio procesado, Pega la url here para añadir otro!');
            }

            return data;
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            $that.addClass('error');
            return false;
          }
        });
        
      });

    },

    movingItems: function(){
      $( "body" ).delegate( "#sortable", "mousemove", function() {
        $( "#sortable" ).sortable({
           delay: 0,     
           connectWith: "div",
           cursor: "move",
           distance: 0,
           grid: [ 1, 1 ],
           opacity: 0.4,
           handle: "h3", // only begin the movement if the mouse is over the h3 element into the list element
           create: function( event, ui ) {
              $('div.ui-state-default').hover(function(){
                id = $( this ).attr('id');
                pos = $( this ).index();
              });          
           },
           update: function( event, ui ) {
              var newPos = parseInt( $("div#"+id).index(),10) - 1;
              if (newPos == -1){ //el objeto ha sido movido a la primera posicion
                var idPrev = 0;
              }
              else{
                var idPrev = $('div.ui-state-default').eq(newPos).attr('id');
              }

              // Create list with new elements order
              var newOrderElems = new Array();
              $("#sortable .twt-elm").each(function() {
                var elemId = $(this).attr("id");
                newOrderElems.push(elemId);
              });
              
              var newOrderElemsJSON = JSON.stringify(newOrderElems);

              var method = 'move';
              var token  = $('#csrf_token').val();
              var request = $.ajax({
                timeout: 10000,
                type: "GET",
                url: radarControler.settings.twtprocessor,
                data: {
                  'method'          : method,
                  'newOrderElems'   : newOrderElemsJSON,
                  'token'           : token
                  
                },                        
              }).done( function(data, status) {
                console.log("MoveItems update: ");
                //console.log(data);
                //console.log('Pos: '+ pos +', id: '+ id +', newPos: '+ newPos +', idPrev: '+ idPrev);

              }).fail( function(request, status, error) {

                console.log('request: ' + request);

                if ( request.responseText != "done"){              
                  console.log('request.responseText: ' + request.responseText);                           
                }

                console.log('status: ' + status);
                console.log('error: ' + error); 

                return false;
              });
           }     
        }); 
      })    

      $( "#sortable, #sortable2, #sortable3" ).disableSelection();    
    },


        // consultas ejecutadas cada minuto: listado de ficheros JSON de streaming y de favoritos, y los totales
    queryList: function(){

      // Ajax call to get data/timeline
      $query1 = $.ajax( radarControler.settings.filesListFile, {
        success: function(data, status){
          radarControler.data.queries.live = data;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
          console.log('error query livefeed list');
          return false;
        },
        timeout: 10000 //
      });

      // Ajax call to get data/timeline
      $query2 = $.ajax( radarControler.settings.filesListFile2, {
        success: function(data, status){
          radarControler.data.queries.api = data;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
          console.log('error query api list');
          return false;
        },
        dataType: 'json',
        timeout: 10000 //
      });

      // Ajax call to get radar total.json data
      $query3 = $.ajax( radarControler.settings.FolderFinalFiles + 'total.json', {
        success: function(data, status){ //console.log(data);
          radarControler.data.totals = data;

            // contamos los post de cada tag
          radarControler.data.tagCount = {}; // reiniciamos cuenta
          if (data.data) {
            for (var i = 0; i < data.data.length; i++) {
              if(data.data[i].tags){
                for (var j = 0; j < data.data[i].tags.length; j++) {
                  if(radarControler.data.tagCount[data.data[i].tags[j]]) {
                    radarControler.data.tagCount[data.data[i].tags[j]] = radarControler.data.tagCount[data.data[i].tags[j]] + 1;
                  } else {
                    radarControler.data.tagCount[data.data[i].tags[j]] = 1;
                  }
                }
              }
            }
          }

          if($('.search-input').length) radarControler.searchTerms.drawTermsCount(); // dibuja los contadores de los inputs
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
          console.log('error query api list');
          return false;
        },
        dataType: 'json',
        timeout: 10000 //
      });

      $.when( $query1, $query2, $query3 ).then( radarControler.processTimeline, radarControler.processTimelineError );
    },          
    processTimeline: function(response){ // dibuja y actualiza el menu con los jsones de datos

      for (var i = 0; i < radarControler.data.queries.live.length; i ++) {
        if (!$.isArray(radarControler.data.queries.live)) {
          var liveStr = radarControler.data.queries.live;
          var live = $.parseJSON(liveStr);
        } else {
          var live = radarControler.data.queries.live;
        }
        var time = live[i];
        if (time != undefined) {
          if(!radarControler.cache.$sidebarStream.find('.bl-list-'+time).length){
            var $elm = $('<div class="bl-list-elm bl-list-'+time+'"><div class="tit">'+
              time.substr(4,2)+':'+time.substr(6,2)+'</div></div>').data('time', parseInt(time));

            $elm.append($('<a href="" class="live-tw">Stream</a>')).data('time', time);

            radarControler.cache.$sidebarStream.prepend($elm);
          }
        }
      };

      for (var i = 0; i < radarControler.data.queries.api.length; i ++) {
        var time = radarControler.data.queries.api[i];
        if(!radarControler.cache.$sidebar.find('.bl-list-'+time).length){
          var $elm = $('<div class="bl-list-elm bl-list-'+time+'"><div class="tit">'+
            time.substr(4,2)+':'+time.substr(6,2)+'</div></div>').data('time', parseInt(time));

          $elm.append($('<a href="" class="tw-api">Favoritos</a>')).data('time', time);

          radarControler.cache.$sidebar.prepend($elm);
        }
      }

      function getMenuParent(time){
        $parents = radarControler.cache.$sidebar.find('.bl-list-elm');
        for (var i = 0; i < $parents.length; i++) {
          var $elm = $($parents[i]);
          if(parseInt($elm.data('time')) < parseInt(time)) return $elm;
        };
        return false;
      }
      //Solo se recarga el panel principal en caso de que estemos con backoffice recién abierto o bien Elementos enviados esté seleccionado.
      if (($(".twt-list").length == 0) || ($(".twt-list h2").text() == "Envios procesados:")) {
          if (($("#config-list").hasClass("config-elm-disable")) && ($("#config-streaming").hasClass("config-elm-disable"))) {
              $("#streaming").trigger("click");
          } 
      }
    },
    processTimelineError: function(){
      console.log('la promesa falló, lalalalal lala');
    },
    processFile: function(response, time){
        // cache
      radarControler.data.processed[time] = response;

        // decorando
      var text = '';
      for (query in response.search) {
        if(response.search.hasOwnProperty(query)){
          text += '<strong>' + query + '</strong>: ' + response.search[query].length + ' ';
        }
      }

      var $elm = $('<a href="" class="bl-list-elm"><div class="tit">'+time.substr(4,2)+':'+time.substr(6,2)+'<span class="small">'+text+'</span></div></a>');
      $elm.data('time', time);
      $('#bl-sidebar-list').prepend($elm);

    },
    themeTweet: function(twet){
      if(twet['net'] == 'ig') { 

        // maquetamos instagram

        var $tweet = $(radarControler.cache.tplImg).attr('id', twet['id']);
        
        $tweet.find('img').attr('src', twet['image']);

        if(twet['user'] && radarControler.data.user[twet['user']]) {
          $tweet.find('.usr').html(radarControler.data.user[twet['user']]['full_name']).attr('href', radarControler.data.user[twet['user']]['link']);
        }
      } else if(twet['net'] == 'tw') {

        // maquetamos twitter

        if(twet['media']) {
          var $tweet = $(radarControler.cache.tplImg).attr('id', twet['id']);
          $tweet.find('img').attr('src', twet['media'][0]);
        } else {
          var $tweet = $(radarControler.cache.tplTwet).attr('id', twet['id']);
        }
        if(twet['user'] && radarControler.data.user[twet['user']]) {
          $tweet.find('.usr').html(radarControler.data.user[twet['user']]['name']).attr('href', 'https://twitter.com/'+radarControler.data.user[twet['user']]['screen_name']);
        }
      } else if(twet['net'] == '+t') {

        // maquetamos +tve

        var $tweet = $(radarControler.cache.tplImg).attr('id', twet['id']);
        
        $tweet.find('img').attr('src', twet['img']);

        $tweet.find('.usr').html(twet['usr']).attr('href', twet['link']);

      } else if(twet['net'] == 'vn') {

        // maquetamos vine

        var $tweet = $(radarControler.cache.tplImg).attr('id', twet['id']);
        $tweet.find('img').attr('src', twet['img']);

        $tweet.find('.usr').html(twet['usr']).attr('href', twet['link']);

      }else { 

        // error
        console.log('tweet sin tipo: ', twet); 
        return false; 
      }

      if(radarControler.isprocessed(twet.id)){
        $tweet.addClass('twt-elm-disable');
      }

        // cosas comunes
        if (twet['type']=="txt") {
          $tweet.find('.tag').css({"background": "blue"});
          $tweet.find('div.fa-plus').show();
        } else if (twet['type']=="img-small") {
          $tweet.find('.tag').css({"background": "green"});
          $tweet.find('div.fa-windows').show();
        } else if (twet['type']=="img-big") {
          $tweet.find('.tag').css({"background": "purple"});
          $tweet.find('div.fa-stop').show();
        }

      if(twet['text']) $tweet.find('h3').html(twet['text']);
      if(twet['tags']) $tweet.find('.tag span').html(twet['tags'].join(', '));
      //if(radarControler.data.user[]);
      $tweet.find('.lnk').attr('href', twet['link']);

      return $tweet;
    },
    drawStreaming: function(naturalSort){ // carga y pinta los tweets procesados

      // Hemos cargado el fichero: totals.json
      console.log("Hemos cargado el fichero: totals.json");

        // theme elementos
      $wrap = radarControler.cache.$timeline;

      $container = $(radarControler.cache.tplWrap);

      $wrap.append($container);

      $container.find('h2').html('Envios procesados:<a href=""><img src="images/reload.png" title="Recargar" alt="Recargar" width="20" height="20" /></a>').next().attr('id','sortable'); // le añadimos el id sortable solo al div de 'envíos proecsados';
      $container.data('type', "total");


      $container = $container.find('.twt-wrap');

      for (id in radarControler.data.totals.data) {

        if(radarControler.data.totals.data.hasOwnProperty(id)){

            // generamos y maquetamos
          var twet = radarControler.data.totals.data[id];

          $tweet = radarControler.themeTweet(twet);

          if(!$tweet) {
          console.log($tweet)} else{
          $tweet.data('twetId', twet['id']).addClass('twt-wipe');
          }
          if(naturalSort){
            $container.prepend($tweet);
          } else {
            if(twet['net'] == 'ig' || twet['media']) { // fotos primero, luego los sin foto
              $container.prepend($tweet);
            } else {
              $container.append($tweet);
            }
          }

        }
      }
    },    
    drawMinute: function(time, type){ // carga y pinta una página de tweets

          // variaciones según busquemos un tipo de archivos u otros
      var apiType = '';
      var filesFolder = '';
      if(type == 'tw-api' || type == 'ig-api') {
        apiType = 'api';
        filesFolder = radarControler.settings.FolderDataFiles2;
      } else if(type == 'live-tw'){
        apiType = 'live';
        filesFolder = radarControler.settings.FolderDataFiles;
      }

        // si aún no tenemos los datos, buscamos al archivo y volvemos a llamar a drawminute cuando esté
      if(!radarControler.data.processed[apiType][time]){

        $.ajax( filesFolder + time + '.json', {
          success: function(data, status){
            radarControler.data.processed[apiType][time] = data;
            radarControler.processUsers(data);
            radarControler.drawMinute(time, type);
            return data;
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            return false;
          },
          dataType: 'json',
          timeout: 10000 //
        })
        return;

      } else {
        var content = radarControler.data.processed[apiType][time];
      }

      radarControler.drawStream(content, apiType, time);

    },
    processUsers:function(data) {
      for (user in data.users) {
        if(data.users.hasOwnProperty(user)){
          if(!radarControler.data.user[user]) radarControler.data.user[user] = data.users[user];
        }
      }
    },
        // rellena un stream para los datos dados
    drawStream: function(content, apiType, time){

        // theme elementos
      $wrap = radarControler.cache.$timeline;

      $container = $(radarControler.cache.tplWrap);

      $wrap.append($container);

      if(content.total){
        $container.find('h2').html('Envios del stream de las '+time.substr(4,2)+':'+time.substr(6,2)+'. Total: '+content.total+' envios:');
      } else {
        $container.find('h2').html('Envios de favoritors de las '+time.substr(4,2)+':'+time.substr(6,2)+'.');
      }
      $container.data('type', apiType);

      $container = $container.find('.twt-wrap');

      for (var j = 0; j < content.search.length; j++) {

          // generamos y maquetamos
        var twet = content.search[j];

        $tweet = radarControler.themeTweet(twet);

        $tweet
          .data({'time': time, 'elm': j, 'twetId': twet['id']})

        if(twet['net'] == 'ig' || twet['media']) { // fotos primero, luego los sin foto
          $container.prepend($tweet);
        } else {
          $container.append($tweet);
        }
      };
    },
    isprocessed: function(id){
      var lengz = radarControler.data.totals.data.length;
      for (var i = 0; i < lengz; i++) {
        if(radarControler.data.totals.data[i].id == id) return true;
      };
      return false;
    },
        // oculta las ventanas que puedan estar abiertas en la parte derecha de la pantalla
    clearRightBar: function(){

      $wrap = radarControler.cache.$timeline;

      $('.bl-list-elm .act').removeClass('act');

      $('.bl-sidebar-bl-act').removeClass('bl-sidebar-bl-act');

        // quitamos otros que haya
      $wrap.find('.twt-list').remove();

      $wrap.find('#config-list').slideUp(400, function() {
        $(this).addClass('config-elm-disable');
        $(this).removeAttr("style");
        $("#settings").html("Configuracion");
      });

      $wrap.find('#config-streaming').slideUp(400, function() {
        $(this).addClass('config-elm-disable');
        $(this).removeAttr("style");
        $("#settings").html("Configuracion");
      });

    }
  };

    // inicializamos el timeline
  radarControler.start(); // initial 

