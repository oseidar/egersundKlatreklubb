/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.ajaxSetup({ cache: false });

function loadInfo(elem){
    console.log(elem.id);
    //console.log($("#myInfoContainer").is(':hidden'));
    switch(elem.id)
    {
        case "myInfoHeader":
            $("#membershipInfoDisplay").load("index.php?module=member&action=getDetails&view=myDetails&id=&ajax=true");
            break;
        case "myChildrenHeader":
            $("#membershipInfoDisplay").load("index.php?module=member&action=getChildren&view=myChildren&id=&ajax=true");
            break;
        case "myCoursesHeader":
            $("#membershipInfoDisplay").load("index.php?module=member&action=getCourses&view=myCourses&id=&ajax=true");
        default:
            break;
    }
}

function getMyDetailsForm()
{
    $("#membershipInfoDisplay").load("index.php?module=member&action=prepareMyDetails&view=myDetailsForm&id&ajax=true");
}

function closeMyDetailsForm()
{
    $("#membershipInfoDisplay").load("index.php?module=member&action=getDetails&view=myDetails&id=&ajax=true");
}

function saveMyDetails()
{
    $.ajax({
         url:"index.php?module=member&action=saveMyDetails&view=blank&id=&ajax=true",
         type:"POST",
         data:$("#myDetailsForm").serialize(),
         success:function(data){
             console.log(data);
             $("#membershipInfoDisplay").load("index.php?module=member&action=getDetails&view=myDetails&id=&ajax=true");
         }
        
    });
}

function makeMeMember(id){
    
    $("#makeMeMemberContainer_"+id).load("index.php?module=member&action=prepareMembership&view=membershipForm&id="+id+"&ajax=true",function(){
        
        $("#makeMeMemberContainer_"+id).slideDown();
        
    });
    
}

function confirmMembership(id){
    
    if($("#membershipType").val() == -1){
        alert("Du må velge medlemsskapstype!");
        return;
    }
    var type = $("#membershipType").val();
    
    $("#makeMeMemberContainer_"+id).fadeOut(400);
    setTimeout(
    function(){
        
        $.ajax({
         url:"index.php?module=member&action=saveMemberShip&view=blank&id="+id+"&ajax=true",
         type:"POST",
         data:{type:type},
         success:function(data){
                console.log(data);
              $("#makeMeMemberContainer_"+id).html(data);
              $("#makeMeMemberContainer_"+id).fadeIn();
              setTimeout(function(){
                  $("#makeMeMemberContainer_"+id).slideUp();
              }, 3000);
              var elem = document.getElementById("myInfoHeader");
              
              loadInfo(elem);
              
             
         }
        
    });
        
        
    },800);
    
    
}

function closeFormById(id){
    $("#"+id).slideUp();
}

function resetMemberShips(id){

    var conf = confirm("Er du sikker, alle medlemskap dette året blir slettet dersom de ikke er registrert som betalt.");
    if(conf){
        console.log("det var ikke bra.. :(");

    $.ajax({
      url:"index.php?module=member&action=resetMemberships&view=blank&id="+id+"&ajax=true",
      type:"POST",

      success:function(data){
           console.log(data);
           alert(data);

            $("#membershipInfoDisplay").load("index.php?module=member&action=getDetails&view=myDetails&id=&ajax=true");
      }
    });
    }
    else{
        console.log("Phuuu, det var bra.. ");
    }
}
function getBill(){
    window.open("index.php?module=member&action=getBill&view=bill&id=&ajax=true", "BillWindow","menubar=0,resizable=0,location=0,width=600,height=800");
}

function getAddMemberForm()
{
    $("#membershipInfoDisplay").load("index.php?module=member&action=&view=newMemberForm&id&ajax=true");
}

function saveNewMember(){
    $.ajax({
         url:"index.php?module=member&action=saveNewMember&view=blank&id=&ajax=true",
         type:"POST",
         data:$("#newMemberForm").serialize(),
         success:function(data){
             console.log(data);
            $("#membershipInfoDisplay").load("index.php?module=member&action=getChildren&view=myChildren&id=&ajax=true");
         }
        
    });
}

function saveEditUser(id){
    console.log(id);
    
    $.ajax({
         url:"index.php?module=member&action=saveEditMember&view=blank&id="+id+"&ajax=true",
         type:"POST",
         data:$("#editMemberForm").serialize(),
         success:function(data){
             console.log(data);
             $("#membershipInfoDisplay").load("index.php?module=member&action=getChildren&view=myChildren&id=&ajax=true");
         }
        
    });
}

function editThis(id)
{
    $("#membershipInfoDisplay").load("index.php?module=member&action=prepareEditMember&view=editMemberForms&id="+id+"&ajax=true");
}

function closeForm()
{
    $("#membershipInfoDisplay").load("index.php?module=member&action=getChildren&view=myChildren&id=&ajax=true");
}

function changePassword()
{
    $("#membershipInfoDisplay").load("index.php?module=member&action=prepareNewPassword&view=newPasswordForm&id=&ajax=true");
}

function logout()
{
    $.ajax({
         url:"index.php?module=member&action=logOut&view=default&id=&ajax=true",
         type:"GET",
         success:function(data){
             console.log(data);
             window.location.reload();
         }
        
    });
    
}

function displayAdminQuickPage()
{
    $("#membershipInfoDisplay").load("index.php?module=member&action=&view=admin&id=&ajax=true");
}

function displayList(elem)
{
    var tmpid = elem.id.split("_");
    if($("#"+tmpid[0]+"_Container").is(':hidden'))
    {
        $("#"+tmpid[0]+"_Container").slideDown();
    }
    else
    {
        $("#"+tmpid[0]+"_Container").slideUp();
    } 
}

function registerPayment(year,id,elem){
    console.log(year +" "+id);
    var button = $("#"+elem.id);
    var conf = confirm("Bekreft merking av betalt medlemsskap. Dette kan ikke gjøres om!");
    if(conf){
    $.ajax({
         url:"index.php?module=member&action=registerMemberPayment&view=blank&id=&ajax=true",
         type:"POST",
         data:{year:year,mid:id},
         success:function(data){
             console.log(data);
             if(data == "true"){
             button.removeClass("notPaid").addClass("paid").show("slow");
             button.slideUp().html("Betalt").slideDown();
             }
             
         }
        
    });
    }
}
function registerBrattkort(id,elem){
    console.log(id);
    var button = $("#"+elem.id);
    var conf = confirm("Bekreft merking av brattkort. Dette kan ikke gjøres om!");
    if(conf){
    $.ajax({
         url:"index.php?module=member&action=registerBrattkort&view=blank&id=&ajax=true",
         type:"POST",
         data:{mid:id},
         success:function(data){
             console.log(data);
             if(data == "true"){
             button.removeClass("notPaid").addClass("paid").show("slow");
             button.slideUp().html("Har brattkort").slideDown();
             }
             
         }
        
    });
    }
}

function openYearForm()
{
    $("#membershipInfoDisplay").load("index.php?module=member&action=confirmAdmin&view=addYearForm&id=&ajax=true");
}