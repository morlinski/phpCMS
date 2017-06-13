<div>
    <h1>Company Name</h1>
    <!--lost appendage-->
    <!--<h4 class="current">current name: Mars</h4>-->
    <div class="preview">
        <div class="hero-content">
            <h1 id="coNamePreview">Prototype</h1>
        </div>
        <div id="CoNameEdit">
            <!--only applied after clicked off of-->
            <!--<input type="text" value="Mars" onchange="changePreview(this.value)">-->
            <input type="text" value="Prototype" onkeyup="changePreview('#coNamePreview',this.value)">
            <input type="button" value="Change" onclick="changeItem('companyName')">
        </div>
    </div>
</div>