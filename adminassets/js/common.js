/*
 * Author: shinith
 * Project :Movie click
 
 **/
 $(document).ready(function(){
var delid="";
 var deltype="";
    /*$('#deleteModal').on('show.bs.modal', function(e) {
        // alert($(e.relatedTarget).data('title'))
        console.log("hiiii")
            deltype=$(e.relatedTarget).data('type');
            console.log(deltype);
            $("#delType").html($(e.relatedTarget).data('title'));
            delid=$(e.relatedTarget).data('delid');
        });*/

        
        $(document).on("click",".openDelModal",function(e){
            e.preventDefault();
            console.log($(this).data('type'))
           deltype=$(this).data('type');
            $("#delType").html($(this).data('title'));
            delid=$(this).data('delid');
            $('#deleteModal').modal("show"); 

        }); 
    
        $(document).on("click","#btnDelete",function(){
             
       $.ajax({"url":ROOT+"ajax/delete-ajax.php",type:'post',data:{"action":"del"+deltype,"delid":delid},success:function(returnData){
             console.log(returnData); 
             try{
             resparray=$.parseJSON(returnData)  ; 
             
             if(resparray.status=="done"){
                location.reload();
             }
             else{
                $("#delErr").html("Deletion not Success");
             }
         }catch(err){}
             
          }
        });
       });
 });

function changeUrl(url) {

            if (typeof (history.pushState) != "undefined") {
                var targetUrl = url,
        targetTitle = document.title;
    window.history.pushState({url: "" + targetUrl + ""}, targetTitle, targetUrl);
    ///setCurrentPage(targetUrl);
            } else {
                console.log("Browser does not support HTML5.");
            }
}
function b64toBlob(b64Data, contentType, sliceSize) {
    //console.log("contentType :"+contentType + " : sliceSize -->"+sliceSize);
    contentType = contentType || '';
    sliceSize = sliceSize || 512;
    //console.log(" sliceSize 12–>"+sliceSize);
    var byteCharacters = atob(b64Data);
    var byteArrays = [];
    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
    var slice = byteCharacters.slice(offset, offset + sliceSize);
    var byteNumbers = new Array(slice.length);
    for (var i = 0; i < slice.length; i++) {
    byteNumbers[i] = slice.charCodeAt(i);
    }
    var byteArray = new Uint8Array(byteNumbers);
    byteArrays.push(byteArray);
    }
    var blob = new Blob(byteArrays, {type: contentType});
    return blob;
    
} 
/*ALLOW ONLY NUMERIC CONTENTS*/   

$(document).on("blur , keyup",".numeric",function(){
    console.log("jijiiiii")
    val=this.value.replace("+","").replace(/ /g,'');
   newval=val.replace(/\D/g,'') 
        if(isNaN(val))
        {
            this.value=newval;
            
            
        }
        
    });
/*ALLOW ONLY NUMERIC CONTENTS*/   

