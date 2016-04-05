<div id="myDetails"  class="table myTable">
    <div class="row">
        <div class="cell">
            <div class="myDisplayWrapper relative">
                <div class="absolute editBtn" id="editMyDetailsBtn" title="Rediger din informasjon" onclick="getMyDetailsForm()">[/]</div>    
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
            <div id="keyCodeContainer" class="info"> Koden til nøkkelboksen er: [@getWallCode()]</div>
            </div>
        </div>
        <div class="cell">
            
            <div class="myDisplayWrapper">
                
                <h4 class="inlineBlock" style="margin-right: 30px;">Mitt medlemskap</h4><button title="Nullstill alle medlemskap dette året. Går kun for de som ikke er registrert betalt." onclick="resetMemberShips([@memberId])">Nullstill medlemskap</button>
                    <div id="myMembershipDetails">
                        
                        [@getCurrentStatus()]
                        [@getPreviousMembership()]
                        [@payCurrentMembership()]
                    </div>
            </div>
            
        </div>
    </div>
</div>