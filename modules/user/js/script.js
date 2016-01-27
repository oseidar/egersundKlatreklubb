/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function loadInfo(elem){
    //console.log($("#myInfoContainer").is(':hidden'));
    
    if(elem.id == "myInfoHeader"){
                if($("#myInfoContainer").is(':hidden')){
                    $("#myInfoContainer").load("index.php?module=member&action=getDetails&view=myDetails&id=&ajax=true",function(){

                            $("#myInfoContainer").slideDown();
                    });
                }
                else{
                    $("#myInfoContainer").slideUp();
                }
        
    }
    else if (elem.id == "myChildrenHeader"){
        
        if($("#myChildrenContainer").is(':hidden')){
                    $("#myChildrenContainer").load("index.php?module=member&action=getChildren&view=myChildren&id=&ajax=true",function(){

                            $("#myChildrenContainer").slideDown();
                    });
                }
                else{
                    $("#myChildrenContainer").slideUp();
                }
    }
    else if (elem.id == "myCoursesHeader"){
        
        if($("#myCoursesContainer").is(':hidden')){
                    $("#myCoursesContainer").load("index.php?module=member&action=getCourses&view=myCourses&id=&ajax=true",function(){

                            $("#myCoursesContainer").slideDown();
                    });
                }
                else{
                    $("#myCoursesContainer").slideUp();
                }
    } 
    else if (elem.id == "myEventsHeader"){
        
        if($("#myEventsContainer").is(':hidden')){
                    $("#myEventsContainer").load("index.php?module=member&action=getEvents&view=myEvents&id=&ajax=true",function(){

                            $("#myEventsContainer").slideDown();
                    });
                }
                else{
                    $("#myEventsContainer").slideUp();
                }
    } 
    
}