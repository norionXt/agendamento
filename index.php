<?php

foreach ( glob('casosUso/*.php') as $key => $arquivo) {
    require_once $arquivo;
}
