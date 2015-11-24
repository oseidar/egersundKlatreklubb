<!DOCTYPE html>
<html>
    <head>
        <title>[@title]</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="app/css/default.css" type="text/css" media="all" rel="stylesheet"/>
        <link href="app/css/bill.css" type="text/css" media="screen" rel="stylesheet"/>
        <link href="app/css/billPrint.css" type="text/css" media="print" rel="stylesheet"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script src="app/js/ajax.js" type="text/javascript"></script>
    </head>
    <body id='bill'>
        <input id='printButton' type="button" onclick="window.print()" value="Skriv ut"/>
        <div id='billContainer'>
            <div id='billHeader' class="table" >
                <div class="row">
                    <div id="titleCell" class="cell">
                        
                        <h1>Egersund Klatre og tindeklubb</h1>
                        <h3>Medlemskap [@year]</h3>
                     </div>
                    <div class="cell">
                        <h3>Faktura</h3>
                        <strong>Org.nr : 987998873</strong><br>
                        Konto.nr : 3270.22.28181<br>
                        Egersund Klatre og tindeklubb<br>
                        Prestegårdsveien 11<br>
                        4370 Egersund<br>
                        
                    </div>
                
                </div>
            </div>
        
            <div id='billText'>
                <h3>Informasjon</h3>
                <p>Dette er medlemsfaktura for [@year]. Du ser her kun utestående beløp. Når beløpet er registrert hos oss, vil kasserer gå inn å merke medlemmene som betalt.</p>
                
                 <p>Vi har pr i dag to medlemstyper. Dette er ordinær og hustandsmedlem. 
                     Alle som er med i husstanden kan være husstandsmedlem etter at husstanden har en - 1 ordinær medlem. 
                     Du er selv ansvarlig for at minst ett medlem er husstandsmedlem. 
                     Ved manglende/utilstrekkelig innbetaling vil du/dere ikke bli merket som betalende medlemmer før betaling/restbetaling er betalt.</p>
                 <h3>Viktig:</h3>
                 <p><strong>Vi gjør dere her  oppmerksomme på §3, §4 og §5 i 
                     <a target="_blank" href="http://mccbase.dwk.no/public/lov.pdf">Lov for Egersund Klatre og Tindeklubb</a> 
                     som omhandler medlemskap, kontingent og stemmerett/valgbarhet.  </strong></p>
            </div>
            <h3>Betalingen gjelder følgende medlemmer:</h3>
            <div class='table' id="billTable">
            <div class='row'>
                <div class="cell name title">Medlemsnavn</div>
                <div class="cell title">Medlemstype</div>
                <div class="cel title ">Linjesum</div>
        </div>
            [@rows]

        </div>
            <div id="sumLine"> <span id="sumTitle" class='inlineBlock'>Sum</span><span class="inlineBlock w50">[@price],-</span></div>
            
            <div>   
            <h3>Betalingsinformasjon:</h3>
            <div style="background-color: #ffffaa" class="table" id="paymentInfoTable">
                <div class="row">
                    <div class="cell">Kontonummer: 32702228181</div>
                    <div class="cell">Sum: [@price],-</div>
                    <div class="cell">Betalingsfrist: [@dueDate]</div>
                </div>
            
        </div>
            <h3 ><strong>Husk å merke innbetalingen tydelig.</strong></h3>
        </div>
        
        
    </body>