<div class="table" id="registerTable">
    <div class="row">
        <div class="cell" id="formCell">
<form  id='signupForm' action="?module=member&action=doRegister&view=thankyou&id=" method="post">
    <input type="text" name="pawned"   id="pawned" style="visibility: hidden;height: 0px" />
    <fieldset>
        <legend><span class="legendSpan">Brukerdata</span></legend>
        <h3>Alle feltene er obligatoriske</h3>
        <ul class="formUl">
            <li>
                <label class="blockLabel" for="firstname">Fornavn</label>
                <input type="text" name='firstname' id="firstname"/>
                
            </li>
            
            <li>
                <label class="blockLabel" for="lastname">Etternavn</label>
                <input type="text" name='lastname' id="lastname"/>
                
            </li>
            <li>
                <label for="dob">Fødselsdato (ÅÅÅÅ-MM-DD)</label>
                <input type="text" name='dob' id="dob" />
                <script type="text/javascript">
                   $( "#dob" ).datepicker({
                    regional:"no",
                    changeMonth: true,
                    changeYear: true,
                    dateFormat:"yy-mm-dd",
                    yearRange:"1940:2012",
                    defaultDate:$("#dob").val()

                });

            </script>
                
            </li>
            <li>
                <label class="blockLabel" for="mail">E-post </label>
                <input type="text" name='mail' id="mail"/>
                
            </li>
            <li>
                <label class="blockLabel" for="mail2">Gjenta E-post</label>
                <input type="text" name='mail2' id="mail2"/>
                
            </li>
            
            <li>
                <label for="password">Passord</label>
                <input type="password" name='password' id="password"/>
                
            </li>
            
            <li>
                <label for="password2">Bekreft passord</label>
                <input type="password" name='password2' id="password2"/>
                
            </li>
            <li>
                <input type="submit" value="Lagre" name="submit" />
            </li>
            
            
        </ul>
    
    </fieldset>


</form>
<script type="text/javascript">

$('#signupForm').validate({ rules: {
firstname: { required: true }, 
lastname: { required: true }, 

mail: { required: true },
mail2: { required: true, equalTo: "#mail" },
dob:{ required:true},
password: { minlength: 6, required: true },
password2: { equalTo: "#password",required: true} },
errorElement: "em",
success: function(label) { label.text('OK!').addClass('valid');
} });

</script>
        </div>
        <div id="registerHint" class="cell">
            <h3 style="color:#cc0000">Viktig informasjon:</h3>
            <ol>
                <li>Du <strong>MÅ </strong> bruke datovelgeren eller skrive inn dato på dette formatet: <strong>YYYY-MM-DD</strong><br><br>
                    
                </li>
                <li>
                    Har du problemer med å registrere deg? Send personalia til: <span id='mailAddress'></span><br>
                    Du får da tilsendt et passord. Du kan da enten bytte eller beholde dette passordet.
                </li>
            </ol>
        </div>
    </div>
</div>

<script type="text/javascript">
$("#mailAddress").html("<a href='mailto:oseidar@gmail.com'> Idar Ose  ( oseidar@gmail.com )</a>");
</script>