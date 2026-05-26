<?php
return [
  'first' => '<li class="page-item"><a href="{{url}}" class="page-link">Primeira</a></li>',
  'current' => '<li class="page-item active"><a class="page-link">{{text}}</a></li>',
  'prevActive' => '<li class="page-item"><a href="{{url}}" class="page-link">Anterior</a></li>',
  'prevDisabled' => '',
  'number' => '<li class="page-item"><a href="{{url}}" class="page-link">{{text}}</a></li>',
  'nextActive' => '<li class="page-item"><a href="{{url}}" class="page-link">Próxima</a></li>',
  'nextDisabled' => '',
  'sortAsc' => '<a href={{url}} class="sortAsc">{{text}}<i class="bi bi-arrow-up"></i></a>',
  'sortDesc' => '<a href={{url}} class="sortAsc">{{text}} <i class="bi bi-arrow-down"></i></a>',
  'last' => '<li class="page-item"><a href="{{url}}" class="page-link">Ultima</a></li>',
  'counterRange' => '<span class="range">{{start}} - {{end}} de {{count}}</span>',
  'counterPages' => '<span class="range">{{page}} de um total de {{pages}} páginas</span>',
];
