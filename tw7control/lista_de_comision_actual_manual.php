<?php 
// segun tabla escalada de comision

if(  $detalles["n_ventas"] < 90 ){ 
  $comision_propia= 512 ;
}elseif( 90 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 120 ){
  $comision_propia= 707 ;
}elseif( 120 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 150 ){
  $comision_propia= 902 ;

}elseif( 150 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 180 ){
  $comision_propia= 1097 ;

}elseif( 180 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 210 ){
  $comision_propia= 1292 ;

}elseif( 210 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 240 ){
  $comision_propia= 1487 ;

}elseif( 240 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 270 ){
  $comision_propia= 1682 ;

}elseif( 270 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 300 ){
  $comision_propia= 1877 ;

}elseif( 300 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 330 ){
  $comision_propia= 2072 ;

}elseif( 330 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 360 ){
  $comision_propia= 2267 ;

}elseif( 360 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 390 ){
  $comision_propia= 2462 ;

}elseif( 390 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 420 ){
  $comision_propia= 2657 ;

}elseif( 420 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 450 ){
  $comision_propia= 2852 ;

}elseif( 450 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 480 ){
  $comision_propia= 3047 ;

}elseif( 480 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 510 ){
  $comision_propia= 3242 ;


}elseif( 510 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 540 ){
  $comision_propia= 3437;
}elseif( 540 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 570 ){
  $comision_propia= 3632 ;
}elseif( 570 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 600 ){
  $comision_propia= 3827 ;

}elseif( 600 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 630 ){
  $comision_propia= 4022 ;
}elseif( 630 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 660 ){
  $comision_propia= 4217 ;
}elseif( 660 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 690 ){
  $comision_propia= 4412 ;
}elseif( 690 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 720 ){
  $comision_propia= 4607 ;
}elseif( 720 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 750 ){
  $comision_propia= 4802 ;

}elseif( 750 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 780 ){
  $comision_propia= 4997 ;
}elseif( 780 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 810 ){
  $comision_propia= 5192 ;

}elseif( 810 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 840 ){
  $comision_propia= 5387 ;
}elseif( 840 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 870 ){
  $comision_propia= 5582 ;
}elseif( 870 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 900 ){
  $comision_propia= 5777 ;
}elseif( 900 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 930 ){
  $comision_propia= 5972 ;

}elseif( 930 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 960 ){
  $comision_propia= 6167 ;

}elseif( 960 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 990 ){
  $comision_propia= 6362 ;
}elseif( 990 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1020 ){
  $comision_propia= 6557 ;
}elseif( 1020 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1050 ){
  $comision_propia= 6752 ;
}elseif( 1050 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1080 ){
  $comision_propia= 6947 ;

}elseif( 1080 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1110 ){
  $comision_propia= 7142 ;
}elseif( 1110 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1140 ){
  $comision_propia= 7337 ;
}elseif( 1140 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1170 ){
  $comision_propia= 7532  ;
}elseif( 1170 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1200 ){
  $comision_propia= 7727 ;
}elseif( 1200 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1230 ){
  $comision_propia= 7922 ;


}elseif( 1230 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1260 ){
  $comision_propia= 8117;

}elseif( 1260 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1290 ){
  $comision_propia= 8312;

}elseif( 1290 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1320 ){
  $comision_propia=  8507;

}elseif( 1320 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1350 ){
  $comision_propia=  8702;

}elseif( 1350 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1380 ){
  $comision_propia=  8897;

}elseif( 1380 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1410 ){
  $comision_propia= 9092;
}elseif( 1410 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1440 ){
  $comision_propia= 9287;

}elseif( 1440 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1470 ){
  $comision_propia= 9482;

}elseif( 1470 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1500 ){
  $comision_propia= 9677;

}elseif( 1500 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1530 ){
  $comision_propia= 9872;

}elseif( 1530 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1560 ){
  $comision_propia= 10067;
}elseif( 1560 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1590 ){
  $comision_propia= 10262;
}elseif( 1590 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1620 ){
  $comision_propia= 10457;
}elseif( 1620 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1650 ){
  $comision_propia= 10652;

}elseif( 1650 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1680 ){
  $comision_propia=  10847;

}elseif( 1680 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1710 ){
  $comision_propia= 11042;

}elseif( 1710 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1740 ){
  $comision_propia=  11237;

}elseif( 1740 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1770 ){
  $comision_propia= 11432;

}elseif( 1770 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2000 ){
  $comision_propia= 11627;

}elseif( 1800 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1830 ){
  $comision_propia= 11822;


}elseif( 1830 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1860 ){
  $comision_propia= 12017;

}elseif( 1860 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1890 ){
  $comision_propia= 12212;

}elseif( 1890 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1920 ){
  $comision_propia= 12407;

}elseif( 1920 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1950 ){
  $comision_propia= 12602;

}elseif( 1950 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1980 ){
  $comision_propia= 12797;

}elseif( 1980 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2010 ){
  $comision_propia= 12992;

}elseif( 2010 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2040 ){
  $comision_propia= 13187;

}elseif( 2040 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2070 ){
  $comision_propia= 13382;

}elseif( 2070 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2100 ){
  $comision_propia= 13577;

}elseif( 2100 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2130 ){
  $comision_propia= 13772;

}elseif( 2130 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2160 ){
  $comision_propia= 13967;

}elseif( 2160 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2190 ){
  $comision_propia= 14162;

}elseif( 2190 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2220 ){
  $comision_propia= 14357;

}elseif( 2220 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2250 ){
  $comision_propia= 14552;

}elseif( 2250 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2280 ){
  $comision_propia= 14747;

}elseif( 2280 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2310 ){
  $comision_propia= 14942;
}elseif( 2310 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2340 ){
  $comision_propia= 15137;

}elseif( 2340 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2370 ){
  $comision_propia= 15332;

}elseif( 2370 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2400 ){
  $comision_propia= 15527;
}elseif( 2400 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2430 ){
  $comision_propia= 15722;

}elseif( 2430 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2460 ){
  $comision_propia= 15917;
}elseif( 2460 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2490 ){
  $comision_propia= 16112;

}elseif( 2490 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2520 ){
  $comision_propia= 16307;

}elseif( 2520 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2550 ){
  $comision_propia= 16502;

}elseif( 2550 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2580 ){
  $comision_propia= 16697;

}elseif( 2580 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2610 ){
  $comision_propia= 16892;

}elseif( 2610 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2640 ){
  $comision_propia= 17087;

}elseif( 2640 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2670 ){
  $comision_propia= 17282;

}elseif( 2670 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2700 ){
  $comision_propia= 17477;

}elseif( 2700 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2730 ){
  $comision_propia= 17672;

}elseif( 2730 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2760 ){
  $comision_propia= 17867;
  
}elseif( 2760 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2790 ){
  $comision_propia= 18062;

}elseif( 2790 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2820 ){
  $comision_propia= 18257;

}elseif( 2820 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2850 ){
  $comision_propia= 18452;

}elseif( 2850 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2880 ){
  $comision_propia= 18647;

}elseif( 2880 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2910 ){
  $comision_propia= 18842;

}elseif( 2910 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2940 ){
  $comision_propia= 19037;

}elseif( 2940 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2970 ){
  $comision_propia= 19232;

}elseif( 2970 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 3000 ){
  $comision_propia= 19427;

}elseif( 3000 <= $detalles["n_ventas"]  ){
  
  $comision_propia= 19622;
}


?>