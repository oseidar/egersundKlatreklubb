<ul id="mainMenu">
    <li>
        <a href="http://www.egersundklatreklubb.no">Hjem</a>
    </li>
    <li>
        <a href="?module=member&action=myMembership&view=default">Arrangementer</a>
        [@subMenuArrangements()]
    </li>
    <li>
        <a href="?module=member&action=myMembership&view=default" >Aktivitet</a>
        [@subMenuActivities()]
    </li>
    <li onmouseenter="displaySubmenu('#subMenuMembership');" onmouseleave="hideSubmenu('#subMenuMembership');">
        <a href="?module=member&action=getMe&view=myMembership&id=">Medlemskap</a>
        [@subMenuMembership()]
    </li>
    <li>
        <a href="?module=member&action=myMembership&view=default">Kontakt</a>
        [@subMenuContact()]
    </li>
    [@menuItemLogInnOut()]
   
</ul>