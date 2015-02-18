function handleImageError(image) {
        $(image).unbind("error").attr("src", "../fotos/silueta-los-oscar-2015.jpg");
    }

$(function() {
    
    $(document).on('change', "input[id^='select_image']", function(){
        readURL(this,this.parentNode.children[0].id);
    });
    $(document).on('click', "img[id^='image_large']", function(){
        $("#"+this.parentNode.children[1].id).trigger('click');
    });
    $(document).on('click', "img[id^='image_medium']", function(){
        $("#"+this.parentNode.children[1].id).trigger('click');
    });
    $(document).on('click', "img[id^='delete_item']", function(){
        $("#"+this.parentNode.parentNode.id).remove();
        //$("#id"+this.id.replace( /[^\d.]/g, '' )).val("-1");
    });
    $(document).on('click', "img[id='add_item']", function(){
        addRow("backoffice_table");
    });
    $(document).on('click', "#commit_back", function(){
        $("#"+this.parentNode.parentNode.id).hide();
        $("#id"+this.id.replace( /[^\d.]/g, '' )).val("-1");
    });
    $(document).on('change', "input", function(){
        $("#"+this.parentNode.parentNode.id).addClass("changed_row");
    });
//    img.addEventListener("DOMAttrModified", function(event) {
//        if (event.attrName == "src") {
//           // The `src` attribute changed!
//        }
//    });
        
    function getMaxRowElement(tableID, element) {
        
        var maxElement = -1;
        $('#'+tableID+' > tbody  > tr').each(function(){
            
            if (element == "id") {
               var actualElement = $(this).find("input[id^='id']").val(); 
            } else {
               var actualElement = $(this).find("input[id^='position']").val();
            }
            actualElement = parseInt(actualElement, 10);
            if (actualElement > maxElement) {
                maxElement = actualElement;
            }
        });
        
        return parseInt(maxElement, 10) + 1;
    }
    
    function addRow(tableID){
        var nextPosition = getMaxRowElement("backoffice_table", "position");
        
	var table=document.getElementById(tableID);
	var rowCount=table.rows.length;
	var row=table.insertRow(rowCount);
        row.setAttribute('id', 'row' + nextPosition);
	var colCount=table.rows[1].cells.length;
	
	for(var i=0;i<colCount - 2;i++){
		var newcell=row.insertCell(i);
                
		newcell.innerHTML=table.rows[rowCount - 1].cells[i].innerHTML;
                var elemento = newcell.childNodes[0];
		elemento.setAttribute('id', elemento.id.replace(/\d+/, nextPosition));
                elemento.setAttribute('name', elemento.name.replace(/\d+/, nextPosition));
                var elementoFile = newcell.childNodes[1];
                if (elementoFile != undefined) {
                    elementoFile.setAttribute('id', elementoFile.id.replace(/\d+/, nextPosition));
                    elementoFile.setAttribute('name', elementoFile.name.replace(/\d+/, nextPosition));
                }
                
                
                //Le asignamos clase a la columna en cuestión
                switch (i) {
                    case 0:
                        newcell.className = "position_cell";
                        break;
                    case 1:
                        newcell.className = "name_cell";
                        break;
                    case 2:
                    case 3:
                        newcell.className = "image_cell";
                        break;
                    case 4:
                        newcell.className = "photographer_cell";
                        break;
                    case 5:
                        newcell.className = "text_cell";
                        break;
                }
                
                //También valor, generalmente se resetea a un valor predefinido (""), salvo en el caso de la posición, que se asigna por defecto el valor siguiente al máximo encontrado.
		switch(newcell.childNodes[0].type){
			case"text":
                            if (i == 0) {
                                elemento.value=nextPosition;
                            } else {
                                elemento.value="";
                            }
                            break;
			case"checkbox":
                            elemento.checked=false;
                            break;
			case"select-one":
                            elemento.selectedIndex=0;
                            break;
                        case undefined: //Si el tipo no está definido, entonces se trata de las imágenes o fotos. Con lo cual se asigna silueta.jpg por defecto.
                            elemento.src="../fotos/silueta-los-oscar-2015.jpg";
                            break;
		}
	}
        //input que contiene id
        var newcell=row.insertCell(i);
	newcell.innerHTML='<input type="text" class="carousel_element_id" id="id' + nextPosition + '" name="id' + nextPosition + '" value="' + getMaxRowElement("backoffice_table", "id") + '"/>';
        newcell.className = "id_cell";
        var newcell=row.insertCell(i + 1);
	newcell.innerHTML='<img class="add_item" id="add_item" name="add_item" src="../images/add.png"/>';
        newcell.className = "action_cell";
        
        //cambiar botón añadir fila de la que era la última fila, por el botón eliminar fila
        var previousRow=table.rows[rowCount - 1];
        previousRow.deleteCell(colCount - 1);
        var newcell=previousRow.insertCell(colCount - 1);
        newcell.innerHTML='<img class="delete_item" id="delete_item' + (rowCount - 1) + '" name="delete_item' + (rowCount - 1) + '" src="../images/delete.png"/>';
    }
    
    function readURL(input,elementId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#'+elementId+'').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("input[id^='id']").last().val(getMaxRowElement("backoffice_table", "id"));
    $("input[id^='position']").last().val(getMaxRowElement("backoffice_table", "position"));
    
    $('#backoffice').on('submit', function(e) { 
        $('.image_large').each(function(){
            if (this.src.indexOf("data:image") == -1) {
               $("#"+this.id+"").attr("disabled", true);
               $("#"+this.id+"").siblings().attr("disabled", true);
            } 
        });
        $('.image_medium').each(function(){
            if (this.src.indexOf("data:image") == -1) {
               $("#"+this.id+"").attr("disabled", true);
               $("#"+this.id+"").siblings().attr("disabled", true);
            } 
        });
        return true;
    });
});


