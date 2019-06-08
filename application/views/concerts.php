<body>
<div id='concerts'>
    <div class='title'>Koncerty</div>
    <div class='content'>
        <div id='table'>
            <ul>
                <li class='row'></li>
                <?php foreach($concerts_incoming as $row): ?>
                     <li class='row'>
                        <div class='date'>
                            <p><?= $row->date ?></p>
                        </div>
                        <div class='club'>
                            <p><?= $row->club ?></div>
                        <div class='city'>
                            <p><?= $row->city ?></p>
                        </div>
                    </li>
                <?php endforeach ?>

                <?php foreach($concerts_past as $row): ?>

                    <li class='row'>
                        <div class='date'>
                            <p class='strikeout'><?= $row->date ?></p>
                        </div>
                        <div class='club'>
                            <p class='strikeout'><?= $row->club ?></p>
                        </div>
                        <div class='city'>
                            <p class='strikeout'><?= $row->city ?></p>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
<div class='clear'></div>