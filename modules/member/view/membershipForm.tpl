<div id="membershipFormContainer">
    <form id="membershipForm">
        <select name="membershipType" id="membershipType">
            <option value="-1">Velg medlemskap</option>
            [@options]
        </select>
        
        <button name="confirmButton" onclick="confirmMembership([@memberId])" type="button" value="confirmButton">Bekreft medlemskap</button>
        <button name="cancelButton" onclick="closeFormById('makeMeMemberContainer_[@memberId]')"type="button" value="cancelButton">Avbryt</button>
    </form>
</div>