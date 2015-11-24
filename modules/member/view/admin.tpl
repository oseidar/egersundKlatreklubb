<div id="adminPanel">
    
    <div id="adminButtons">[@getAdminButtons()]</div>
    
    <div id="adminContent">
    
    <div>Det er nå [@numMembers()] registrerte medlemmer.</div>
    
    
 
    <div class="memberItem" id="memberListWrapper">
        <div class="listHeader" id="memberList_Header" onclick="displayList(this);">Medlemsliste</div>
            <div id="memberList_Container" style="display: none;" >
                [@getMemberList()]
            </div>
        </div>

        <div  class="memberItem" id="paidListWrapper">
            <div class="listHeader" id="paidList_Header" onclick="displayList(this);">Betalt-liste</div>
            <div id="paidList_Container" style="display: none;" >
                    [@getPaidMemberList()]

            </div>
        </div>

        <div class="memberItem" id="dueListWrapper">
            <div class="listHeader" id="dueList_Header" onclick="displayList(this);">Ikkebetalt-liste</div>
            <div id="dueList_Container" style="display: none;" >
                    [@getDueMemberList()]

            </div>
        </div>
    </div>
</div>
