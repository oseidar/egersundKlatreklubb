/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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