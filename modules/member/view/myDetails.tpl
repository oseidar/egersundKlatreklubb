<div id="myDetails"  class="table myTable">
    <div class="row">
        <div class="cell">
            <div class="myDisplayWrapper relative">
                <div class="absolute editBtn" id="editMyDetailsBtn" onclick="getMyDetailsForm()">[/]</div>    
            <h4>Kontaktperson info</h4>
                <ul class="infoUl">
                    <li>
                        Navn: [@firstName] [@lastName] 
                    </li>
                    <li>
                        Adresse: [@adress] 
                    </li>
                    <li>
                        Postnr: [@zip] 
                    </li>
                    <li>
                        Fødselsdato: [@birthDate] 
                    </li>
                    <li>
                        E-post: [@email] 
                    </li>
                    <li>
                        Telefon: [@phone]
                    </li>
                </ul>
            <div id="myDetailsFormContainer" style="display: none"></div>
            </div>
        </div>
        <div class="cell">
            
            <div class="myDisplayWrapper">
                
                <h4 class="inlineBlock">Mitt medlemskap</h4><button onclick="resetMemberShips([@memberId])">Nullstill medlemskap</button>
                    <div id="myMembershipDetails">
                        
                        [@getCurrentStatus()]
                        [@getPreviousMembership()]
                        [@payCurrentMembership()]
                    </div>
            </div>
            
        </div>
    </div>
</div>