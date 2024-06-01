<?php 
// segun tabla escalada de comision

if(  $detalles["n_ventas"] < 90 ){ 
  $comision_propia= 512 ;
}elseif( 90 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 120 ){
  $comision_propia= 707 ;
}elseif( 120 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 150 ){
  $comision_propia= 902 ;

}elseif( 150 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 180 ){
  $comision_propia= 1025 ;

}elseif( 180 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 210 ){
  $comision_propia= 1220 ;

}elseif( 210 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 240 ){
  $comision_propia= 1393.4 ;

}elseif( 240 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 270 ){
  $comision_propia= 1566.8 ;

}elseif( 270 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 300 ){
  $comision_propia= 1740.2 ;

}elseif( 300 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 330 ){
  $comision_propia= 1913.6 ;

}elseif( 330 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 360 ){
  $comision_propia= 2087 ;

}elseif( 360 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 390 ){
  $comision_propia= 2260.4 ;

}elseif( 390 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 420 ){
  $comision_propia= 2433.8 ;

}elseif( 420 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 450 ){
  $comision_propia= 2607.2 ;

}elseif( 450 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 480 ){
  $comision_propia= 2780.6 ;

}elseif( 480 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 510 ){
  $comision_propia= 2954 ;


}elseif( 510 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 540 ){
  $comision_propia= 3127.4;
}elseif( 540 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 570 ){
  $comision_propia= 3300.8 ;
}elseif( 570 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 600 ){
  $comision_propia= 3474.2 ;

}elseif( 600 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 630 ){
  $comision_propia= 3647.6 ;
}elseif( 630 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 660 ){
  $comision_propia= 3821 ;
}elseif( 660 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 690 ){
  $comision_propia= 3994.4 ;
}elseif( 690 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 720 ){
  $comision_propia= 4167.8 ;
}elseif( 720 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 750 ){
  $comision_propia= 4341.2 ;

}elseif( 750 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 780 ){
  $comision_propia= 4514.6 ;
}elseif( 780 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 810 ){
  $comision_propia= 4688 ;

}elseif( 810 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 840 ){
  $comision_propia= 4861.4 ;
}elseif( 840 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 870 ){
  $comision_propia= 5034.8 ;
}elseif( 870 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 900 ){
  $comision_propia= 5208.2 ;
}elseif( 900 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 930 ){
  $comision_propia= 5381.6 ;
}elseif( 930 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 960 ){
  $comision_propia= 5555 ;
}elseif( 960 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 990 ){
  $comision_propia= 5728.4 ;
}elseif( 990 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1020 ){
  $comision_propia= 5901.8 ;
}elseif( 1020 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1050 ){
  $comision_propia= 6075.2 ;
}elseif( 1050 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1080 ){
  $comision_propia= 6248.6 ;
}elseif( 1080 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1110 ){
  $comision_propia= 6422 ;
}elseif( 1110 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1140 ){
  $comision_propia= 6595.4 ;
}elseif( 1140 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1170 ){
  $comision_propia= 6768.8 ;
}elseif( 1170 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1200 ){
  $comision_propia= 6942.2 ;
}elseif( 1200 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1230 ){
  $comision_propia= 7115.6 ;


}elseif( 1230 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1260 ){
  $comision_propia= 7289 ;
}elseif( 1260 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1290 ){
  $comision_propia= 7462.4 ;
}elseif( 1290 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1320 ){
  $comision_propia= 7635.8 ;
}elseif( 1320 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1350 ){
  $comision_propia= 7809.2 ;
}elseif( 1350 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1380 ){
  $comision_propia= 7982.6 ;
}elseif( 1380 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1410 ){
  $comision_propia= 8156 ;
}elseif( 1410 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1440 ){
  $comision_propia= 8329.4 ;
}elseif( 1440 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1470 ){
  $comision_propia= 8502.8 ;

}elseif( 1470 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1500 ){
  $comision_propia= 8676.2 ;
}elseif( 1500 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1530 ){
  $comision_propia= 8849.6 ;
}elseif( 1530 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1560 ){
  $comision_propia= 9023 ;
}elseif( 1560 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1590 ){
  $comision_propia= 9196.4 ;
}elseif( 1590 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1620 ){
  $comision_propia= 9369.8 ;
}elseif( 1620 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1650 ){
  $comision_propia= 9543.2 ;
}elseif( 1650 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1680 ){
  $comision_propia= 9716.6 ;
}elseif( 1680 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1710 ){
  $comision_propia= 9890 ;

}elseif( 1710 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1740 ){
  $comision_propia= 10063.4 ;
}elseif( 1740 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1770 ){
  $comision_propia= 10236.8 ;
}elseif( 1770 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2000 ){
  $comision_propia= 10410.2 ;
}elseif( 1800 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1830 ){
  $comision_propia= 10583.6 ;


}elseif( 1830 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1860 ){
  $comision_propia= 10757 ;
}elseif( 1860 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1890 ){
  $comision_propia= 10930.4;
}elseif( 1890 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1920 ){
  $comision_propia= 11103.8;
}elseif( 1920 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1950 ){
  $comision_propia= 11277.2 ;
}elseif( 1950 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 1980 ){
  $comision_propia= 11450.6 ;
}elseif( 1980 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2010 ){
  $comision_propia= 11624 ;
}elseif( 2010 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2040 ){
  $comision_propia= 11797.4 ;
}elseif( 2040 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2070 ){
  $comision_propia= 11970.8;
}elseif( 2070 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2100 ){
  $comision_propia= 12144.2 ;
}elseif( 2100 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2130 ){
  $comision_propia= 12317.6 ;
}elseif( 2130 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2160 ){
  $comision_propia= 12491;
}elseif( 2160 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2190 ){
  $comision_propia= 12664.4 ;
}elseif( 2190 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2220 ){
  $comision_propia= 12837.8 ;
}elseif( 2220 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2250 ){
  $comision_propia= 13011.2;

}elseif( 2250 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2280 ){
  $comision_propia= 13184.6 ;
}elseif( 2280 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2310 ){
  $comision_propia= 13358 ;
}elseif( 2310 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2340 ){
  $comision_propia= 13531.4 ;
}elseif( 2340 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2370 ){
  $comision_propia= 13704.8 ;
}elseif( 2370 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2400 ){
  $comision_propia= 13878.2 ;
}elseif( 2400 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2430 ){
  $comision_propia= 14051.6 ;
}elseif( 2430 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2460 ){
  $comision_propia= 14225 ;
}elseif( 2460 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2490 ){
  $comision_propia= 14398.4 ;
}elseif( 2490 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2520 ){
  $comision_propia= 14571.8 ;
}elseif( 2520 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2550 ){
  $comision_propia= 14745.2 ;
}elseif( 2550 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2580 ){
  $comision_propia= 14918.6 ;
}elseif( 2580 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2610 ){
  $comision_propia= 15092 ;
}elseif( 2610 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2640 ){
  $comision_propia= 15265.4 ;
}elseif( 2640 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2670 ){
  $comision_propia= 15438.8 ;
}elseif( 2670 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2700 ){
  $comision_propia= 15612.2 ;
}elseif( 2700 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2730 ){
  $comision_propia= 15785.6 ;
}elseif( 2730 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2760 ){
  $comision_propia= 15959 ;
  
}elseif( 2760 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2790 ){
  $comision_propia= 16132.4 ;
}elseif( 2790 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2820 ){
  $comision_propia= 16305.8 ;
}elseif( 2820 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2850 ){
  $comision_propia= 16479.2 ;
}elseif( 2850 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2880 ){
  $comision_propia= 16652.6 ;
}elseif( 2880 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2910 ){
  $comision_propia= 16826 ;
}elseif( 2910 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2940 ){
  $comision_propia= 16999.4 ;
}elseif( 2940 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 2970 ){
  $comision_propia= 17172.8 ;
}elseif( 2970 <= $detalles["n_ventas"] &&  $detalles["n_ventas"] < 3000 ){
  $comision_propia= 17346.2 ;

}elseif( 3000 <= $detalles["n_ventas"]  ){
  
  $comision_propia= 17519.6 ;
}


?>