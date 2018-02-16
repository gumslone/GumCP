<?php
	include_once('../../include/config.php');
	
	if($gumcp_modules['adminer']['module_active']!=1)
	{
		header("HTTP/1.0 404 Not Found");
		exit();
	}


/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 4.6.1
*/error_reporting(6135);$Vc=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($Vc||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$zi=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($zi)$$X=$zi;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");if(isset($_GET["file"])){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");if($_GET["file"]=="favicon.ico"){header("Content-Type: image/x-icon");echo
lzw_decompress("\0\0\0` \0„\0\n @\0´C„è\"\0`EãQ¸àÿ‡?ÀtvM'”JdÁd\\Œb0\0Ä\"™ÀfÓˆ¤îs5›ÏçÑAXPaJ“0„¥‘8„#RŠT©‘z`ˆ#.©ÇcíXÃþÈ€?À-\0¡Im? .«M¶€\0È¯(Ì‰ýÀ/(%Œ\0");}elseif($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("\n1Ì‡“ÙŒÞl7œ‡B1„4vb0˜Ífs‘¼ên2BÌÑ±Ù˜Þn:‡#(¼b.\rDc)ÈÈa7E„‘¤Âl¦Ã±”èi1ÌŽs˜´ç-4™‡fÓ	ÈÎi7†³é†„ŽŒFÃ©”vt2ž‚Ó!–r0Ïãã£t~½U'3M€ÉW„B¦'cÍPÂ:6T\rc£A¾zr_îWK¶\r-¼VNFS%~Ãc²Ùí&›\\^ÊrÀ›­æu‚ÅŽÃžôÙ‹4'7k¶è¯ÂãQÔæhš'g\rFB\ryT7SS¥PÐ1=Ç¤cIèÊ:d”ºm>£S8L†Jœt.M¢Š	Ï‹`'C¡¼ÛÐ889¤È ŽQØýŒî2#8Ð­£’˜6mú²†ðjˆ¢h«<…Œ°«Œ9/ë˜ç:Jê)Ê‚¤\0d>!\0Z‡ˆvì»në¾ð¼o(Úó¥ÉkÔ7½sàù>Œî†!ÐR\"*nSý\0@P\"Áè’(‹#[¶¥£@g¹oü­’znþ9k¤8†nš™ª1´I*ˆô=Ín²¤ª¸è0«c(ö;¾Ã Ðè!°üë*cì÷>ÎŽ¬E7DñLJ© 1Èä·ã`Â8(áÕ3M¨ó\"Ç39é?Ee=Ò¬ü~ù¾²ôÅîÓ¸7;ÉCÄÁ›ÍE\rd!)Âa*¯5ajo\0ª#`Ê38¶\0Êí]“eŒêˆÆ2¤	mk×øe]…Á­AZsÕStZ•Z!)BR¨G+Î#Jv2(ã öîc…4<¸#sB¯0éú‚6YL\r²=£…¿[×73Æð<Ô:£Šbx”ßJ=	m_ ¾ÏÅfªlÙ×t‹åIªƒHÚ3x*€›á6`t6¾Ã%UÔLòeÙ‚˜<´\0ÉAQ<P<:š#u/¤:T\\> Ë-…xJˆÍQH\nj¡L+jÝzðó°7£•«`ÝðŽ³\nkƒƒ'“NÓvX>îC-TË©¶œ¸†4*L”%Cj>7ß¨ŠÞ¨¨è-ŽƒÈà2‡¹pÂ3Œ¢îb–àÙ¥°¨çÞv>ñœp\\²ŒÃê6_HˆÛ»CxïW†1OjùAwH7q£ \\ÉŽ#¨ÒÉ®ýrŒ4v=ŸnòvÑO‰–÷6‡gWpß×ù'eÚy¯—ŸÝ÷¡pî0#z6=ÙÖ€u¡º\\_Ä.¬â£>H<rÞ+cz%}®w÷ÈVˆA*€¸Ã—B>dR:\rê‰\rœðl\rÕ9´jð43•¸qm\rPN	ðØAãþ`ÅûÁµxoÃ¨m\rÁì8?ÔüÃõ,	E·,UèŒ‚âêìòŸ%z®Ê›¬5õ’ˆvÃìvE 86H0[C¼Lmj¨2D¨¢¦Á`pŠÑ1?ÁRÀQŽÊÛMæÅxšžbéu±Å&˜âI-\"¡Ê§žÛV\"òÍpG\"W†±èŽ\$¦Š“J\$6†PæPÜÄu\"ˆT7CHòÖ–{÷‘²=Ë†UªŸtuIYxµ¢6–#èrŽpbMÉý’å\\ˆÑ7VRÒØÜo\":\$bCA¸F!Ñ\$—–	E0f\0F€krÊ)“0`b*4‚Kç¾ˆêR\\…„`k7¦ô„Àº]–`×(\$ôä7DHÊDè%	ç\\çO³ÂsNÕÜ°å*V’ ŸÈØê]	âÞÊs§C1p¼ÕvjÂÉªM€aº†# µØQQ¢(ÌR|Ë“õfÔmhšW\$Ÿš3H:%„Ò•êh\\V‘\$7‡_Ê:Î¡iý@¨4OK)p:¦¾™@2äC»(ÎEgö`C\"\$üžÔ¤¼“JÑ2±\$9‡4dÊµA â”PQb.iõb´´Èñ)TÁX/A„¾@:ÌT[­íf¸œ	®©)ãGP`Ú–D“t(c¡Èú6w\0Èò<2´Æ? tØ0k/§¬öžõ)>x#”ì=<´K,¢@.4!®	Ö½ÜLbŠ2Z•\0[IKî‰\$ 3‘eõ¢%¨}öTµ¿BýŠý5NöáDÚ Þvœ3sˆO¥ÀXPG#h¤,…ÖZãÈfÅ”\"’NÁp©0@šT•É7‹ÝDïZÊ¿ºó0\0XÔZÎp±[KhyªŽ:ìñYÄ|òÙCx,ª_‰ÑÌè.jŽ¦øIƒC\$1f<9bìà©Û[˜6Þ\0ç}ïÌŽ1~Øáh–¦ÁÞÃÏn¡â@Þu­n(Áà€™`äûNÌ+¯kÑ‡ÐFA–é nˆŠö1´L­\"áp(¥•\"ip¢AšWjâCd².QS½Ùˆ¨FºÖ˜	<´¼Šå_#[ä«\0daÊŠâ»aqtf¸oÆâÃâ&bYíG(d5ä±ÁÞgj'™›™àÆQ;È—(^Ì‰QZ-i™ãÌt²LÉ®…é„ÙP<+S–]QÈÐùTª	ÐüÖ2˜49ÎR™’Ãp-½ÀÙ÷YLùF‰Ù›' ì¸`ôM²:§%™')ƒYuÙKìº©x#Ö¦è¦+ÌR«é\nÁ\nÄù†š´’#HºÅXÂ²á¶¾Ôwvädm¶xƒ\n¼2qìÉ†å·~÷•ÜÏ×{lØvKÀsî_À›‰à–D~ô4˜BÙ¬T]!K8ƒìÝÃâÐw±ÊeB‡ è\0hCYVÜ­zbO&åÙßòy>Ÿ`Ç2W‘øÄs^P¥l×B &öUÉyµÎ·®9ôh;–Ô*Ž\rý#”dsú·-þi,¥»^;û”²¿/>]˜ó`GœNsÎ·»Û€e¥zÖ˜åÍßŸ+Ã²æ/ßlê@ï·eËÊ+¾|o•ó÷£Ûß:ƒì!­Oºå’`ùÏf»×¦¾®ÛÔH@‘§s|“~PL¸(he2—%¶Ñiè:\0á¥‚ö»¾*ðÝO#y<¹¯ìº{`Ô·Ôã\\’Jº};)é¿–øAQ³n¨ªÔu7BáôÏ³çÔd³êÚNß»qï¼oÀëâÛõ‹öþ¯iÎŸ`=ýþöCïš2„Úú“\\•ñü…ó»0…íŒüO„ÀMtøŒÞúÏÖû0µ+fSiÝhÎ\r¨‹e6ÎÈØ¶DÄAà6ƒlX)|+d œP67 è\r ¾ ÀÚƒj6êãð5PM¢oPZ7ÝB\0Ð\0¾{@ÇÐUuÐ|7€ðk`ZƒpŒ4P‡	 çgô’BÐ/¨“0‰0›£Dð³ ¾¡(V—Ä\0fiH¯ÄÐÔ	…Ç‚\rð›0æ ß	pe\nÀ[ ÊGšSpå	\nº\r€¿›hÕ¨[ê¼ðéQ¥ô—É&Äp«ð½	œ\0r˜K›P‹ ¾Â›°uŽ{QbšÕÍN.­S\rÐ¯Q\0W‘Aí‘Sh…±m‘uÀò©©Ž‘§u„0â*ú+ îµä®Hñ/DöðJ‘ðþ=‘²ƒô- éÐíqÂiðU1¿‘ÍÐCQH\rˆëÈÓ\r@Œ±?1®è7’Ó‘±Âœrr!Qã‘ç	±ß qêSQî´=¤Ž˜R8™Qª7¯	 ð\r±	èê/p©	Á\$RI£Ù!¬O%QÝRe\$‹BÁÒ ò1\r&±Y‰|q ä_ÈK/Ç(«)e	À¾\r`Ê0›	R¤lð‘'ÐU*Ò§qR™(çG	”2f`—ÒQ)ð‹r½qq‘-‘1.puÁ-±Crìòð1o²á\rðt\0Ï.SS`¿0Óƒ1 Ú‘ê½/RßÀ¿2s0’/£\\e2Ðu+S3óC/±5¤pÔS]°T]ó16PÎe	5³mƒ,Ž©¯J)õ4	{5iŸ#ÐfÇ’N®’S\nÌy	 «±£±ò>(Ó+6ñU¦ª“Ó¹2þÇ³0ó·	³róð›4ÓÁæ])39‰ªäÀ  Ø«rû3s3É?3+5|*ÓæÑèÜ‘p‘óû!4 ßAs9³Ã3“ùBs@e9‰|8B8©|,&ò‘çä²ß è	Ðbœ‹DÀ¦Â©È®@R6sŠ6Ë:010±K0GÃBï@n¡¤C`Ü8bë#D'DB?D†ú\$P,´T•N±E±†´^/4c#ëêèe");}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("f:›ŒgCI¼Ü\n8œÅ3)°Ë7œ…†81ÐÊx:\nOg#)Ðêr7\n\"†è´`ø|2ÌgSi–H)N¦S‘ä§\r‡\"0¹Ä@ä)Ÿ`(\$s6O!ÓèœV/=Œ' T4æ=„˜iS˜6IO“ÊerÙxî9*Åº°ºn3\rÑ‰vƒCÁ`õšÝ2G%¨YãæáþŸ1™Ífô¹ÑÈ‚l¤Ã1‘\ny£*pC\r\$ÌnTª•3=\\‚r9O\"ã	Ààl<Š\rÇ\\€³I,—s\nA¤Æeh+Mâ‹!q0™ýf»`(¹N{c–—+wËñÁY£–pÙ§3Š3ú˜+I¦Ôj¹ºýŽÏk·²n¸qÜƒzi#^rØÀº´‹3èâÏ[žèºo;®Ë(‹Ð6#ÀÒŽ\":cz>ß£C2vÑCXÊ<P˜Ãc*5\nº¨è·/üP97ñ|F»°c0ƒ³¨°ä!ƒæ…!¨œƒ!‰Ã\nZ%ÃÄ‡#CHÌ!¨Òr8ç\$¥¡ì¯,ÈRÜ”2…Èã^0·á@¤2Œâ(ð88P/‚à¸Ý„á\\Á\$La\\å;càH„áHX„•\nÊƒtœ‡á8A<ÏsZô*ƒ;IÐÎ3¡Á@Ò2<Š¢¬!A8G<Ôj¿-Kƒ({*\r’Åa1‡¡èN4Tc\"\\Ò!=1^•ðÝM9O³:†;jŒŠ\rãXÒàL#HÎ7ƒ#TÝª/-´‹£pÊ;B Â‹\n¿2!ƒ¥Ít]apÎŽÝî\0RÛCËv¬MÂI,\rö§\0Hv°Ý?kTÞ4£Š¼óuÙ±Ø;&’ò+&ƒ›ð•µ\rÈXbu4Ý¡i88Â2Bä/âƒ–4ƒ¡€N8AÜA)52íúøËåÎ2ˆ¨sã8ç“5¤¥¡pçWC@è:˜t…ã¾´Öešh\"#8_˜æcp^ãˆâI]OHþÔ:zdÈ3g£(„ˆ×Ã–k¸î“\\6´˜2ÚÚ–÷¹iÃä7²˜Ï]\rÃxO¾nºpè<¡ÁpïQ®UÐn‹ò|@çËó#G3ðÁ8bA¨Ê6ô2Ÿ67%#¸\\8\rýš2Èc\ræÝŸk®‚.(’	Ž’-—J;î›Ñó ÈéLãÏ ƒ¼žWâøã§“Ñ¥É¤â–÷·žnû Ò§»æýMÎÀ9ZÐs]êz®¯¬ëy^[¯ì4-ºU\0ta ¶62^•˜.`¤‚â.Cßjÿ[á„ % Q\0`dëM8¿¦¼ËÛ\$O0`4²êÎ\n\0a\rA„<†@Ÿƒ›Š\r!À:ØBAŸ9Ù?h>¤Çº š~ÌŒ—6ÈˆhÜ=Ë-œA7XäÀÖ‡\\¼\r‘Q<èš§q’'!XÎ“2úT °!ŒD\r§Ò,K´\"ç%˜HÖqR\r„Ì ¢îC =Ží‚ æäŽÈ<c”\n#<€5Mø êEƒœyŒ¡”“‡°úo\"°cJKL2ù&£ØeRœÀWÐAÎTwÊÑ‘;åJˆâá\\`)5¦ÔÞœBòqhT3§àR	¸'\r+\":‚8¤ÀtV“Aß+]ŒÉS72Èð¤YˆFƒ¼Z85àc,æô¶JÁ±/+S¸nBpoWÅdÖ\"§Qû¦a­ZKpèÞ§y\$›’ÐÏõ4I¢@L'@‰xCÑdfé~}Q*”ÒºAµàQ’\"BÛ*2\0œ.ÑÕkF©\"\r”‘° Øoƒ\\ëÔ¢™ÚVijY¦¥MÊôO‚\$Šˆ2ÒThH´¤ª0XHª5~kL©‰…T*:~P©”2¦tÒÂàB\0ýY…ÀÈÁœŸj†vDÐs.Ð9“s¸¹Ì¤ÆP¥*xžª•b¤o“õÿ¢PÜ\$¹W/“*ÃÉz';¦Ñ\$ž*ùÛÙédâmíÃƒÄ'b\rÑn%ÅÄ47Wì-Ÿ’àöÕ ¶K´µ³@<ÅgæÃ¨bBÑÿ[7§\\’|€VdR£¿6leQÌ`(Ô¢,Ñd˜å¹8\r¥]S:?š1¹`îÍYÀ`ÜAåÒ“%¾ÒZkQ”sMš*Ñ×È{`¯J*w¶×ÓŠ>îÕ¾ôDÏû›>ïeÓ¾·\"åt+poüüŸÊ=Þ*‚µApc7gæä ]ÓÊlî!×ŽÑ—+ÌûzsN¦îýàÀPÔšòia§y}U²ašÓù™`äãA¥­Á½Áw\n¡óÊ›Øj“ÿ<­:+Ÿ7;\"°ÕN3tqd4Åºg”ƒ¦T‹x€ªPH¨—FvWõV\nÕh;¢”BáD°Ø³/öbJ³Ý\\Ê+ %¥ñ–÷îá]úúÑŠ½£wa×Ý«¹Š¦»á¦ðèE‘­(iÉ!îô7ë×x±†z¤×Ò÷çÅHÉ³¸d´êmdéìèQ±r@§a•î¤ja?¤\r”\ryë4-4µfPáÒ‰WÃÊ`,¼x@§ƒÝx¼ˆèA’¦K.€OÁi€¯o²;ê©ö–)±Ð¨ºä’É†SÙdÙÓeOý™%ÙNÐåL78í¦Fãª›§SîáÒùöIÁÂ\rîÛZ˜²r^‰>ýÐì*‚d\ri°YüëYd‹uÃës‡*œ	ÌèE ¡Ê½éD§9æë!Â>ùkCá€›A‡ŽÁd®åâ°!WWì1ððÿŽQAæœÛk½°d%¦Ü# ïy†°{›–`}Té_YY‹R®ð-¹MôºO–2ÖâÊ,Ë,Å É`ú-2ÓÀ÷¨+]L•È7E¤Ôç{`¢ƒË•­ñ~wì-…×ý ©M6¥¤]Fóûƒ¦@™§Ìe`°/˜8¹@‡e¦ÍØ\\ap.‚H¥ûÐC´Àæ*EAoz2¹Æçg0úˆ?]Í~Ÿs°ñÏ`ŒhJ`†êç®¤`û}‡áÍ^`èÑÃ>§ÈOñ5\rðW^Iœõžõ\n³ù¬ý;ñ¸´ð:ŸäÏ_h›n±µŒ´ßYP4®ðˆ)û *ý¸îÉõ¯æÑ6vÖä[Ë¤­C;ûö³ïã»¶näW/jº<\$J*qÄ¢ûä°ú-LôŒ\0µ¯ãï÷\0Oš\$ëZW zþ	\0}Ú.4F„\rnu\0âàØÀä‹’éLÞ ÷IA\nz›©*–©ªŠjJ˜Ì…PŠ¢ë‚Ðp…Â6€Ø¦NšžDÈBf\\	\0¨	 ˜W@L\rÀÄ`àg'Bd¯	Bi	œ°‚‰*|r%|\nr\r#Ž°„@w®»î(T.¬vâ8ñÊâ\nm˜¥ð<pØÔ`úY0ØÔâðÀÊö\0Ð#€Ì‘}Ž.I œx¢T\\âôÑ\n ÍQ‘æ@bR MFÙÇ|¢è%0SDr§ÂÈ žf/b–àÂá¢:áík/þã	f%äÐ¨®e\nx\0Âl\0ÌÅÚ	‘0€W`ß¥Ú\nç8\r\0}pŽ²‘›Â;\0È.Bè¤Vù§,z&Àf Ì\röWOcKƒ\nì» ž’åÒkªz2\rñÉÀîW@Â’ç%\n~1€‚X ¤ßqâD¢!°^ù¦t<§\$²{0<E¦ÊÑª³2&ÜNÒ\r\næ^iÀ\"è³#ný ì­#2D§ˆüË®DâŽæo!¬zK6Âë:ŽïìÃÏð#RlÓ%q'kÞ¾*¸«Ã€à¶ Z@ºòJÌ`^PàHÀbSR|§	Ž%|öôì.ÿ¯Âµ²^ßrc&oæÑk<ÿ­þí&þ²xK²Õ'æüLÄ‚«ò‹(ò’òmE)¥*–ÿ¬`R¥bWGbTRø½î`VNf¢®jæð´woVèè˜(\"­’Ú§ô&s\0§².²¦Þ³8ž=h®ë Q&üŽân*hø\0òv¢BèGØè@\\F\n‚WÅr f\$óe6‘6àaã¤¥¢5H•ñâ°bYÐfÓRF€Ñ9¨(Òº³.EQå*Êî¸ë(Ú1‰*Â/+,º\"ˆö\r Ü	ªâ8ý\0ˆü3@Ý%låŽ­ã¥,+¼¼å&í#-\$¦óÈ%†ÌÅgF!sÝ1³Ö%¯Ôsó/¥nKªq”\0O\"EA©8…2ÀŠ}5\0Ë8‹ŸA\n¯ÅRrH…Ú³‡9Å4UìdW3!b¨z`í>ãF>Òi,”a?L>°´`´r¾±r ta;L¦ëÅ%ÀRxîŒ‰R†ëtŠÊ¥HW/m7Dr¶EsG2Î.B5Iî°ëÉQ3â_€ÒÔˆë´¤§24.ì‰ÅRkâ€z@¶@ºNì[4Î&<%b>n¦YPWÎŸâ“6n\$bK5“t‡âZB³YI Lê~G³YÎÖñcQc	6DXÖµ\"}ÆžfŠÐ¢IÎj€ó5“\\ö XÙ¢td®„\nbtNaEÀTb;lâp‚Õ|\0Ô¯x\n‚žådVÖíŒÖà]Xõ“Yf„÷%D`‡QbØsvDsk0ÓqT¥ÿ7“l c7ç€ä ÖôŽÎSZ”6äï¾ãµŠÄž#êx‚Õh Õšâ¬£`·_`Ü¾ÎÚ§±•ê¥œ·+w`Ö%U§…’ï©è™¯¶ïÌ»U òöD‹Xl#µ†Ju¯[ åQ'×\\Hð÷„¤÷äGRÕë0«oaÐõÓCÃX¥+ÔaícàNäž®`ÖreÚ\n€Ò%¤4šS_­k_àÚšŽ!3({7ó’bI\rV\r÷5ç×\0µ\\“€aeSg[Óz f-PöO,ju;XUvÐîýÖÃmËl…\"\\B1ÄžÝÅ0æ µ‘pðå4á•ë;2*‘î.b£\0ØØuÔãJ\"NV‰ÛrrOÕfî2äW3[‰Ø¢”¤³	€ËÆ5\r7²Ë0,ytÉÛwS	W	]kGÓX·iA*=P\rbs\"®\\÷o{eÀòœ¶5k€ïkÆ<±‚;®;xÕ¶-ö0§É_\$4Ý ²¶´™8*i\0f›.Ñ(`¼•òñD`æP·&Œô˜ŒÄA+eB\"ZÀ¨¶³¢WÌ¢\\M>¶wö÷ú¶Ëg0¦ãGààš…‘Òø´\rÆÜ©*Ýf\\òŒp\0ð¼‚åKf#€ÛÀËƒ\rÎÙÍ¡ƒØ@\r÷‚Öd ¢Ÿ\nó&D°%‚Ø3­wý‚©.}÷ùÏÿÅ­‚ ñ‚kHÆk1x~]¸PÙ­Óƒ€[…Œ;…ÀY€ØˆØ‘KÅ6 ËZäÖàtµ©>gL\r€àHsMìºe¤\0Ÿä&3²\$ë‰n3íü wÊ“7Õ—®·\"ôÒë+Ý;¢s;é” *1™ y*îŽË®;TG|ç|B©! {!åÅ\"/Ê–oÎãj÷Wë+µæ“LþDJþ’Í…´w2´ÆVTZ¹Gg/šýÖŠƒ]4n½4²À¿±Á‹Ï÷i©=ÈT…ˆ]dâ&¦ÀÄM\0Ö[88‡È®Eæ–â8&LXVmôvÀ±	Ê”j„×›‡FåÄ\\™Â	™ÆÊ&t\0Q›à\\\"òb€°	àÄ\rBs	wžÂ	ŸõŸ‚N š7ÇC/|Ù×	€¨\n\nNúýK›yà*A™`ñWÏYvUZ4tz;~0}šñJ?hW£d*#É3€åÐžàyF\nKTë¤Åæ@|„gy›\0ÊOÀxôa§`w£Z9¥ŒbO„»¨ÚWY’RÄÉ}J¾ˆXÊÚPñU2`÷©šG©åbeuª…zWö+œÈð\rè¬\$4ƒ…\"\n\0ž\n`¨X@Nà‹®%d|‚hé¬ÈÚ™ÞÅ‡egÄê‚+âH¸t™(ªÞÑ( À^\0Zk@îªP¦@%Â(WÍ{¬º/¯ºþt{o\$â\0[³èÞ±¡„%¡§ë´É™¯‚hU]¤B,€rDèðe:D§¢ÌX«†V&ÚWll@ÀdòìY4 Ë¯›iYy¡š[‘¬Ã+«Z¹©]¦g·‡FrÚFû´wÞµ”#1¦tÏ¦¤ÃN¢hq`å§Dóðð§v|º¦Z…Lúv…:S¨ú@åeº»ÿB’ƒ.2‡¬EŠ%Ú¯Bè’@[”ŠúÖB£*Y;¿™[ú#ª”©™›µ@:5Ã`Y8Û¾–è&¹è	@¦	àœüQÅS8!›£³»Â Â¼¢2MYŽ„äO;¾«©Æ›È)êõFÂ¨FZõA\\1 PF¨B¤lF+šó”<ÚRÊ><J?šÚ{µf’õkÄ˜8®ëW‚¬èë®ºM\r•Í¼Û–RsC÷NÍô€î”%©ÊJë~Á˜?·Úâ¯,\r4×k0µ,JóªŽ•b—öo\0Ê!1 ø5'¦\ràø·u\r\0øÊ\$¡Ð=š}\r7NÌÔ=DW6Kø8võ\r³ Ê\n ¤	*‚\r»Ä7)¦ÏDüm›1	aÖ@ßÖ‡°¨w.äT”ÈÝ~©Ç¼pV½ÀœJ‚u¢\rä&N MqcÊdÐÐdÐ8îžðØ€_ÐK×aU&®H#]°d}`P¬\0~ÀU/ª…ñƒ…ùÌynY<>dC·<GÉ@éÃ\"’eZS¹wã•›“ÆGy¼\\j)ð}ž•¤\r5â1,pª^u\0èéˆÕÆnÌÚC©ºHPÖ¬G<Ÿšp‹ô2¨\nèFDÜ\rÖ\$°­yuycöçõv6Ýe)ÖpÛYHÏÄ’õÞ#VP¾€üÕØeW®Þ=žmÙæc:&‰¥æ-ÛÄPv.£Ë€øæºðš	‹úØ£\0\$êÁ@+×ì¹Pÿl&_çCb-U&Ž0\"åF…®Vy¸p\rÄa5Ûq9U>5è\\LBg†èU­[¶7m düóyV[5Ÿ*}Õ4ø5/ç¶àÒ¾HöD60 ¿­Åì¿íÃ:Suy\r„¼‡ãSMÀŸÂ;W“ªØÎµL4ÖG¢NØã°§–Ÿõ ÜeÜmðšt„Èsq¶€˜\".Fÿ™Ž§CsQ¸ h€e7äünØ>°²*àc!iSÝj¾†Ì­Ù‘ü°ø‚°ü {üµ­÷%t€ê\0`&lrÅ“,Ü!0ahy	RµB=ÍegWãùo\0¦H‡h/v(’N4‘\rý„ÀTz„&q÷?X\$€X!ôJ^,Ÿ­öbó“ý`2@:†¼7ÃCX’H€e¡Š@qïÛ\ny¶ 0¦è‹´£´€ñPÀO02@èv‰/IPa°2ÀÜ0\n]-(^Æüt.½•3&Ç\"«0¤˜\"Ð\0]°1šÍñaÂ˜´°E³SúÄP|\\€ÉÑAõpú9›\$K˜ˆByuØ¯zë7Z•\rìb¤uÉ_ïò8õÆmãq³ðû˜E<-ÈÉ@\0®!)³Ä )÷)Õ~Qå	rÙ‘Ü/MèPÿ\nº	¦É`à!\n(ˆ‚\n\n>X€Ð!` WºËáø¼àp4AÚ	Å¶Á©d‘Ç\0XÒÙ§V\n€+Cd/EØFåâ¯m+`\0Þ2´ôp/-ØÌ2·™´eæËC@C„\0pX,4½ìª¼ƒÌ9àòÔXt!.Pß˜\\ý•q„£b{…vˆbfMÃÍ)D]ûw„˜°ŸË… XàB4'»—fÀtXÐ¦¢(O Õ¾©	ð‘qü#ž³3¸«p]¢i\".ªè7¬iw[T\0y\rÄ4Cå;,\$a2i(™\$µmÈ†DÒ&Ô”4¥žZ â;E#6UAÄR€­üìeFFUŒ1•h2\n¨÷UpÖ‡ÃžéTÊ¹€âÏØÕ[î+‘^ôXÕ¤Ù78 A\rnK‚‚d1´>€pƒ+¦`Î:‡‹Iƒo<ÚL„@äa	¾€´\0:ˆ†ÝG—½ hQ„\$ùjR¸Ç'ÉÈŒ¯K!ý`¨£¸1ÅÒÀHƒCÆâZ0\$ÀeÉyXG£5hÎEâ\r1ŸG‚\nº`·g'\0¼Ý6qVã(\r‡„VPHöÇŒëbÖŠ\r¯-k–\0B‘bÆýØGß:½áŒZ×Ñ|¹>Ž*ÄXXÙ!¡’£´\"&öÀ:EÕa«÷,vB P‰h!pf;\0£¾[Á‘/r:qTŽƒèÙ8\"x3Gl‘Ý\"Xm#Ã`è5ÑæÜx\n¨óG¶;ÑþEQ—X¹Ç‚<HhAúå¢ê·+1Nsº´ã¡µk•jsH{€Øõãï&1•GãaIÊ?76š22Îp4™þ—È™V!°Á‡¢º2ÍŸ:€¤z	IàÄ‰ZÔ1ER7ÃÝ%£¶ÂôÅ6!Á?@(•ä–‘ï,&…2’¸ò”>™I8 ÒP+œ”‚hâ&7N'2V˜š\0Ñ¢i\0œ‡ËÜ™i%8ù¹V8e„Z:Ò@Ê´°ñ6ä¦R{¨JzÔs2…	j(C`Z*ôˆJ-bçë#¸DEu\$¹WŒ*Œ¥*#9ˆ”D3y¥?\"Ø9ý,Q”/§ßw8ˆ‚UÀ=•qÿ™]\0ƒÊ¹¸mŽtøŒ-*ç(˜ðdÒ‰•!Žåƒ+FX\$IŒÌ„âîˆ¼ºU\$õ`‚‚Ìeò'c¦¿Vr¨n«Æ1l€Šõ5¬?XTÅ&*@ òIBÖtyt–fêõN¨ð%ÂÅS™H˜xô\$Ü\0}/sH\\§Ë†°ÊË6@y1Ž\0~@+ÄVñ7UÀLh`_CÀÆ€‰hBA|‰œ*pEÍí	 \"Ö‰0\0‰0\$R‹ìªåp\0§Š€[’²gØfb²rí«ÈÍ\0PÙ÷,™\0œtcð€ÿ¦|d	£Ë,F‡œÂ€Ó0Ç6+šU¬û•¤æ’[	ZLü½íRŠ%j—€È4³I€æÈ#xŸ»´WÀvàßÅô6M´\"€mãP‚U7P6Í¾n /	tÝRšAp©Í<R3NX†\0Ð¬S|1KÐ@0<Í„S	O+ÜÚJÁ7`1ÍâoS`Ñ8³	æe“–›¨X€ç7Q´†æs*œØ@W2ÁMZaÇ¼Kà…¸ñE@è\r³œÅ¦lê¹ÚÌX(/äjž0ñ¢Y¨<WÃ7Z²Ç‡|£&H|å‚Ù…©…%TŸsFGNq<Iˆ„î—ˆ€¶7&-žzƒV ‚[±öwç¼1\\ô•ÖS–\r©:‹œ³£S-ÕŸ}Á2äƒŠ>‘ô„9h£`,=´ÔRÈ°©œJe4Kp—EÂ€E‰”}H¤Š¢a@ &;à–Ž{.	’€ó!²ÚÙIÁÒ0cÞØf¸:\ráPwNŠu¢¦åW”Î+°»™ËM\0007Š|!Æž¨YhæéWÐ\$i;IÛaL¹§…\$SÂ ,‹S.Se±@N0y*Û¦&†ŠäD\0dÉ¤OE°1EuÅqë2J}EÄô+  DZê§è¹EâÖ+a[O;(Ä‡Edm}\0eû\0äÀ4\rîŽË…+‘À_ÿ§P“l—uÔÚÉ±öQ½Q	À\$ÊÂ–1µ¢!\\º«\n1O)6]u &’K' èÇGš=tæLDÀ×?H¨Òš‡¥H¿(ÃHJTRLaÿ¥e ¿Bñ‰Þ€[dÐ½‹\nR†=­BSgF”á‰nÊ˜\0²¬¥0e‚c&«@¨Ð–¸½òõ1â‚\0\0ÀOŽ›)>z¨&0½ÁMÊÈèÔZJj«Ä›…%Î!‘z¯\0Î8¸¦AP²¢P‚y‚¯FcDJ°Ñ‰6¦¹-Èî‘ÐÆúŸ„ìRY&ÈÎ~²˜\$á	 ™žCÊ4àc#;ÈšAbÝ­#CŠhBBtOÍh;±p×l”‚¥uòž\nY	Â'‘ÈïŒ¹ÁÔ\03á\0¼	€IX@ø \"µÐ\0P§Z4ÀTŒWUCª,ˆô€°©›(	¿š	MÞ,—®¬†ÅP`IÈô¡hÓèé/Qœ\0ˆèôÿÓø@)\nFH‚ùíÃÈ€ÎÂâ’°QoÂ@>SÜC@pøHàîÆV@Bn—	a1éÄžEÖ*Ÿ5aªH7dP\n¦Bç JDüžJ– ú¬ã&§ê{À¶žAà'’h5-à°@t§‰©)dJu°¦è†ðJqUèóQ¯«%NÉSê(&­.ŒR°T°õÍÂeµr=\\SÞˆªâˆš§‡¯­hnêÑNµãˆäY\"Ñ\n\nJxƒG\r\0œr5Û½T@×[`€…”éZ\r‚Ip%|åA*9w\"¨+è˜ø¡2c¡ƒl«9#\$Í@aðÄò*³TÀ@\0+°€+=a9ÃC«I¿¡ÀY~#ñ!ÚÂ‹B™?è°åA‰\nŒÀE!ˆkC€-Ád’fkŽí^\0ÀUùk5‡8¬i‹xOÒèyå¹¢¸è|á¿0´ 7?ZÌŠQL2.R~€eñõ—üwcõµ ü	…\$ qË·*)2ŠŒhu/{8!95-Ol -Ù-ê\"b¹€s¨Õ^*9f“:\$éõ!@,Z‡¦.µtŠæÍ0Th‡a{<YúÌAL´¿lf@ÐØÕ«\n–@	×áR“œ=B¹ªXžt[êfj…¨\0µ(•¨%¸c§2¸Ç#™´xâ„¡{UµD«®whï-^¿)ë˜üÈ&C0bŽŒZƒ+<ÇFN_…ë­a!¸,!\r§m€¬›ZªºÕO°³Bi`0:Ø3¡MO(¶\\¿ŠÝÙ„]rF9Õ¸††ZÀÚl‰59·0E„V¿è²M<6Š…—MÊFÇcŽHw-G°¶o19¨«Í6Ô¥€¤öu …ÏÖ•Š”øQ–¤èÇ¶I*+XšâTEEÅá:¡ÉÂÉì¹tvqÈî²£HŠi§œZyº¿VMž|KO4†Ê¦‡óÙž}AXÂP%¬VSÚºåƒúÐ€º¥IM’)njcª’1Yóð/}ÔR®íH¬±Ì¬fö®l’Ç¢ÇÂç'ë@½×ƒúkÚð4·>V\$ùh˜a•#ðâ{¨|k8Áÿ]š›d›è.t¾ŸEÑ—z)Ä'îÝxT·ÚÍÝ†!º=ÒjT@À]4ñ'’ª‹ãnŠÁ´>!(ˆFiÅtK·¬öé÷{€;-ï&¸‚‰ñîñŠ‹×zÄO¢çàsº	§o^¢ø¥¨·Ø\\,}Hó¿\$53å’M„×ª@!\"`\"!À¹Í×l·èð²ÑÃ„uîÏ÷{Û‰Ž˜°.²ñ+qæ°\0œfÁf7ÝHj5ì&ÇCÓ±àšá÷T‚Ù É©”.KIW-ÑîèÀ^<•J¬æ@´¦Ÿ<»‰›‰˜ëâjÌÁ8²ÇæeÛ)ƒxüÂ PH#Ö¯Pö'~•îÅRû	è¥¿èG%K‘#æäŒ¥\\ÉÓÄã}„‘qî2L\$Nt_	;7ÆzµòJ5|Ã}©ðMÞ7Ú©N<ßEsàgÕð°Q,!.'—Ï\n~pVøa7	OÂ&—dšFePAõtaê„k6¨¶ýkZƒ¬~Oæ ÀDŸ·‚P.2“+#Yq(Jµ“M‹PÕ&º×)c/—æ ’OnF²{¼0ÿ„ƒÿ9Ù\0006T8Ø[eŠâ;µ\0ÁSà˜æZË:|õ,:T±ˆa‡‰\\Kç7¯xuSñ\$à–:\\#¸£n>&×ý‰ÑFâ¤]¸¬P+OÔS'Ü²ÜíY`³bÃbzbb¸¶Âº ù*ëI	_b}ÄjF€çz»ÎØx\0/Æ)‹”pº~Éé†!œ·ˆÀ-Þ²<XeªðF˜÷Fb(ùxàO C‰ô(Hej¨¯ÀYIÉèïÄÅ@qT“Ë:Ï<Í±À\\ð—f<„ˆr,z§ÏtÝoŒyC@@'à|\r˜KGà7I¨n¬¨å†»ñR[‡^p”C€«+	EÅ9b— •R¦3\0¶`/ÀÄ]yöC±èÖ<‰cROÍ\"u J‡[ÏäÉê8ÊÇ^M²q`\0ŽÑðØñQÆ²\"3xØX×&!¢ÈXÎÆ”s8ÂÅÚ¾Ä¸°ÎÕ¼†Ç©”­a 2±K\0™ÁSa¢ÇÎ(‰Œ€—¯öNÆË(ÇÚYáQèjRÅº?²ÊÅXãA¹æ‰	N\nEKb~ãÿ„ÒËØp\r˜?æ'^Åº‡ïØÑðãô¶;v°U+=—¿Xí–¢³<U~ý—–ãÕœõWÃxp@YU{%AÊrÄÉj¸ŸØ ˜Z<S9½>p+nÐ Aq—ñ%f\rŽó’Ž	 àE\n˜¸¸‡'š¬è–üz²—s|ó¯~ËîÁºß!Ì9¤#¢“&;ßÐº©ÙÌÚ”¬ÉL›3¦m÷.íö#oø°<×Ó‹6DzÎ:å@M2 N¼3³¤=­óƒx¢¯€Ÿ8™ÅÐ:PÚþÌâ\n8\0+Ð…S7œ	«;™Þf\"pt1=\r`W:Èþ®°ÊápO[q@4žŽÍc¶Ê\$]äx{¨Æesìª,±f¼—˜ÌŒZúÖtPùWÇ¹§¤òµ‹ö:3‚¾ä{ã®¿‘—?`\r\r3¡é „ÄŽ,2RÑ™ŠP(Rãˆ7G{½º¡tK¢pñ0ˆÞÏvèp!,nø÷àAŽK(·€¼\n@As]\0ùT6¸WØõ_¹\nrÓ.äpÐúu]ò{ÊI¤< “MázÓÆJ@ø{LèºÞWMÑÎ<ÌÍ¨Àã›Dý:pNDµA©C+ìjË?µNkßÀ]üˆç¹d¢ðG€ÕÌ‡¹í2¶¯\rÅ‹‘ÉêÞäÇ#¡Û/šÒE†`¦˜º²Ø-[2eØ:Ñc‹_8eÉr²\$Ø\nH bhÒ×(N¶¥zEµ­%[ïþ”¥Vá•Êb‚gÃ×ôçê‰\n®Ì¾fç|¢\0-!¹jR¡ˆª`Ü`ÖýÀõ%ØÛ}g*ñ“Úµô^É¶ÊM\\\\¢R‰*¹ˆc.g£I€ò ”BrUBn…Yúm^ÆÖZ+\0RðÊA‰%WPÔÑ\"Ù(]ö\\`/bÃ‰± ¼E¶aß,b®Øï6Mƒ[Ý#›	Á'åˆÊ-™2ëf›§†Å.os+çSQ,›b¬f6WvýS’ñ;\$ÙìéÒì”Ä§%ëe[º®Ëdˆ•™&ëWbfÚdgµYî&dL>Ù\rG§-µÔ¥%ßl)Q’c,ówÆ[ë:zÄÎÍ³™ôÓwk´Å®@HXúe\"–¾!Ws++‰ˆX`=Í\næQˆ»°€cÛPÓøÆÄÄDFÒoîk³^íH¼ÖÄ6\nÁ¤nÎŸdÎŸÝeÐ”YÛ¾fV¬•?Ÿ‰½Éº¨÷–\n>á`­¨š	_êÑç”w‚^\0º§*]¯Ë5{ˆ\n÷‚§i…h69¡#6|,]ÆÏî•»‘¿šB!ÆZƒ¨j\0[ßRP7–S‡xŠyé…²ÂüÈÔÈ{«Ìho±~ ÔšGpœÈ@Ip\0Š€)+fdY ì´HkŽlt'6ñÙpEÐùÀã0À^Eì­nÑ¥#°Ýõ\$Wbu	Ø¨NFom=Œ\$Õ%W>¨:TÀw\\!.ðÃdv´Ù.ÞvÀ—¾p¿iÞàªV6a¾­¡\nËQŒtÜ]ð7ˆ„CFì‘»¸¸Q¶æXíÃr)-\\Ž!*–Äo»A@KªRÒð”þ¯æGG1L;¤Nl[ØMn—\$Qê\"Gœ½dA‰é›â\nÁŠ|naO”'Nf.]¬ièQ¶;”~N ­¢¤àRH7˜0MxÚ 	À¨ÀñyœrÑ¤©PN¢¹-nHÔÞï†.°j„·uÉjvÍÇ•Xq4Ÿ¼R‰8r’Ãgê¡Ä5€îP›¬S¡\nÔSíu+½Hñü\r²pš@ @ P  x‘T±äÒò ,ÍœªCÓ'\n£j¢ˆ,¨ÓŠé²æÈpC÷S¦Ýâçy²V\"Óx›E˜¯¶ò2@v=ns‹L\$€YçRpQ®´v´i·š¯4ð1H¬È\\ç2£ó\0©\\Kp‡øV|ñ\rËi\$‹7À6¼Þ¤j9éŠ.ˆ*ñG'áQ¡[ÅÎ~¶ù„Ü†µ\0‹òËÀ¥ÍŽ@%LêP üæF6 ß´‘GŠgºøœK^H•\n0ñH†k§Ô~^ñVŠEÅÇOÓòœ\nŽÄ”W ½ó‹e…\"`Vf.]v8zVc\r;:â½TÏU”cÕˆ¨t]^ºvyî‹V´tBPÕ.=B2@bÐº2 =H8)¸­äC\0»\\à- WøÃG^«—½\"§2Q‡Yrün„Ó­ïÑ@ßÝ§ddCT¤½‰O\\zéÄ g­Â~xäúèÍÀÅ¸'fÏS=p üáÎöO³`'ìê¯;ÞÆv8\$6FìH{\"^Ê¿Ÿ°¨áÏf{_ÙÁØ)˜Ð7í\0M»D“.ÒÛ´ÈâíA;T{àw\näié‹…G,#Ô\ry£ý7S¨ÃûÔž»qo>€.ï'^ªç×Âµ¥áÀl&ßü§¬Òªõ­oUÈ¾;¾ŒDlÏ­#¯è [ß^ÝõŸ¿XØïçJº¿Ø.Ãö¦—Ã,ºVÖŽè¿Õg6>[æ€šw2}ÈQ¦ÑÄ:h4€÷¶\"NR®@cá^ÿu;µ }ð¿f’}\$d€¯±!Âîü[\\øˆ\\ýht;æ2/x«¸=Õ§MéN‚ä…È\\ý¼'o¼cÚÎàù)e~8©}| ŽÅ”?šIéŠ¬¨¸>Ï)t—½c	pz«å,Áêõ÷žjNÚ˜ˆ&ûÔt3ž`-èÀëÊŸç :t8ƒ¯·”ºJÖSÁ32·‘ú¸-À9ß†ÁÀ+€Ÿ…0¾ØÓâ>‡–\rÙÀT®wþ&üþ˜àŸŽoé‰”¨VQ0gUfËRŸKúgÓ^œÙ BëÇXÂØ9”ê]‰ƒ…Ò	ÞæƒŸc€ìœïE51XõKØy¿ØjU `—lƒc) ðË€¿ë´£<P…öH\0fòZú\0++àOkL”\0\$‹^ù|Î–WùüÂd™<¸0u§œ·\$ZªzŽ€(=£øõW–60ÖvOŒÁëÄO…•ÿpÌ‰B¢9’ð5í¶´ÍHD_ÍWÅ5•øxÁeæÀž\$gF¥<€ðo+õ.åœA}¿ªAcwÄ#Œz— GFîÀÇ¨7\"kh)úâ\r+á!ŒÞßòe\0à+8•ÇK@l€à\0Wò2<*ä¡÷hþ<ÆŽü\$tãRÕ¿¼8840@:ø‡Óþ–ž§?€rñwB€Qó‘Å0\rˆÈ=÷Ïø'Û_¢\nøÿUçf”€uôp8}%(ÑújÓü¥ÀÁËë/á¦\0v½Ìž™@*+áE.ÿÀ=ÄK›ûœËZð 	~Êg'é@3 ?ƒ/½ØÖ°b¿vPñTü¶X²Ñ“Øõ›áÂ†åÆ©t{¼P>€");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("v0œF£©ÌÐ==˜ÎFS	ÐÊ_6MÆ³˜èèr:™E‡CI´Êo:C„”Xc‚\ræØ„J(:=ŸE†¦a28¡xð¸?Ä'ƒi°SANN‘ùðxs…NBáÌVl0›ŒçS	œËUl(D|Ò„çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\nŽ?Kb±iw|È`Ç÷d.¼x8EN¦ã!”Í2™‡3©ˆá\r‡ÑYŽÌèy6GFmYŽ8o7\n\r³0¤÷\0DbcÓ!¾Q7Ð¨d8‹Áì~‘¬N)ùEÐ³`ôNsßð`ÆS)ÐOé—·ç/º<xÆ9Žo»ÔåµÁì3n«®2»!r¼:;ã+Â9ˆCÈ¨®‰Ã\n<ñ`Èó¯bè\\š?`†4\r#`È<¯BeãB#¤N Üã\r.D`¬«jê4ÿŽŽpéar°øã¢º÷>ò8Ó\$Éc ¾1Écœ ¡c êÝê{n7ÀÃ¡ƒAðNÊRLi\r1À¾ø!£(æjÂ´®+Âê62ÀXÊ8+Êâàä.\rÍÎôƒÎ!x¼åƒhù'ãâˆ6Sð\0RïÔôñOÒ\n¼…1(W0…ãœÇ7qœë:NÃE:68n+ŽäÕ´5_(®s \rã”ê‰/m6PÔ@ÃEQàÄ9\n¨V-‹Áó\"¦.:åJÏ8weÎq½|Ø‡³XÐ]µÝY XÁeåzWâü Ž7âûZ1íhQfÙãu£jÑ4Z{p\\AUËJ<õ†káÁ@¼ÉÃà@„}&„ˆL7U°wuYhÔ2¸È@ûu  Pà7ËA†hèÌò°Þ3Ã›êçXEÍ…Zˆ]­lá@MplvÂ)æ ÁÁHW‘‘Ôy>Y-øYŸè/«›ªÁî hC [*‹ûFã­#~†!Ð`ô\r#0PïCË—f ·¶¡îÃ\\î›¶‡É^Ã%B<\\½fˆÞ±ÅáÐÝã&/¦O‚ðL\\jF¨jZ£1«\\:Æ´>N¹¯XaFÃAÀ³²ðÃØÍf…h{\"s\n×64‡ÜøÒ…¼?Ä8Ü^p\"ë°ñÈ¸\\Úe(¸PƒNµìq[g¸Árÿ&Â}PhÊà¡ÀWÙí*Þír_sËP‡hà¼àÐ\nÛËÃomõ¿¥Ãê—Ó#§¡.Á\0@épdW ²\$Òº°QÛ½Tl0† ¾ÃHdHë)š‡ÛÙÀ)PÓÜØHgàýUþ„ªBèe\r†t:‡Õ\0)\"Åtô,´œ’ÛÇ[(DøO\nR8!†Æ¬ÖšðÜlAüV…¨4 hà£Sq<žà@}ÃëÊgK±]®àè]â=90°'€åâøwA<‚ƒÐÑaÁ~€òWšæƒD|A´††2ÓXÙU2àéyÅŠŠ=¡p)«\0P	˜s€µn…3îr„f\0¢F…·ºvÒÌG®ÁI@é%¤”Ÿ+Àö_I`¶ÌôÅ\r.ƒ N²ºËKI…[”Ê–SJò©¾aUf›Szûƒ«M§ô„%¬·\"Q|9€¨Bc§aÁq\0©8Ÿ#Ò<a„³:z1Ufª·>îZ¹l‰‰¹ÓÀe5#U@iUGÂ‚™©n¨%Ò°s¦„Ë;gxL´pPš?BçŒÊQ\\—b„ÿé¾’Q„=7:¸¯Ý¡Qº\r:ƒtì¥:y(Å ×\nÛd)¹ÐÒ\nÁX; ‹ìŽêCaA¬\ráÝñŸP¨GHù!¡ ¢@È9\n\nAl~H úªV\nsªÉÕ«Æ¯ÕbBr£ªö„’­²ßû3ƒ\ržP¿%¢Ñ„\r}b/‰Î‘\$“5§PëCä\"wÌB_çŽÉUÕgAtë¤ô…å¤…é^QÄåUÉÄÖj™Áí Bvhì¡„4‡)¹ã+ª)<–j^<Lóà4U* õBg ëÐæè*nÊ–è-ÿÜõÓ	9O\$´‰Ø·zyM™3„\\9Üè˜.oŠ¶šÌë¸E(iåàžœÄÓ7	tßšé-&¢\nj!\rÀyœyàD1gðÒö]«ÜyRÔ7\"ðæ§·ƒˆ~ÀíàÜ)TZ0E9MåYZtXe!Ýf†@ç{È¬yl	8‡;¦ƒR{„ë8‡Ä®ÁeØ+ULñ'‚F²1ýøæ8PE5-	Ð_!Ô7…ó [2‰JËÁ;‡HR²éÇ¹€8pç—²Ý‡@™£0,Õ®psK0\r¿4”¢\$sJ¾Ã4ÉDZ©ÕI¢™'\$cL”R–MpY&ü½Íiçz3GÍzÒšJ%ÁÌPÜ-„[É/xç³T¾{p¶§z‹CÖvµ¥Ó:ƒV'\\–’KJa¨ÃMƒ&º°£Ó¾\"à²eo^Q+h^âÐiTð1ªORäl«,5[Ý˜\$¹·)¬ôjLÆU`£SË`Z^ð|€‡r½=Ð÷nç™»–˜TU	1Hyk›Çt+\0váD¿\r	<œàÆ™ìñjG”ž­tÆ*3%k›YÜ²T*Ý|\"CŠülhE§(È\rÃ8r‡×{Üñ0å²×þÙDÜ_Œ‡.6Ð¸è;ãü‡„rBjƒO'Ûœ¥¥Ï>\$¤Ô`^6™Ì9‘#¸¨§æ4Xþ¥mh8:êûc‹þ0ø×;Ø/Ô‰·¿¹Ø;ä\\'( î„tú'+™òý¯Ì·°^]­±NÑv¹ç#Ç,ëvð×ÃOÏiÏ–©>·Þ<SïA\\€\\îµü!Ø3*tl`÷u\0p'è7…Pà9·bsœ{Àv®{·ü7ˆ\"{ÛÆrîaÖ(¿^æ¼ÝE÷úÿë¹gÒÜ/¡øžUÄ9g¶î÷/ÈÔ`Ä\nL\n)À†‚(Aúað\" žçØ	Á&„PøÂ@O\nå¸«0†(M&©FJ'Ú! …0Š<ïHëîÂçÆù¥*Ì|ìÆ*çOZím*n/bî/ö®Ôˆ¹.ìâ©o\0ÎÊdnÎ)ùŽi:RŽÎëP2êmµ\0/vìOX÷ðøFÊ³ÏˆîŒè®\"ñ®êöî¸÷0õ0ö‚¬©í0bËÐgjðð\$ñné0}°	î@ø=MÆ‚0nîPŸ/pæotì€÷°¨ð.ÌÌ½g\0Ð)o—\n0È÷‰\rF¶é€ b¾i¶Ão}\n°Ì¯…	NQ°'ðxòFaÐJîÎôLõéðÐàÆ\rÀÍ\r€Öö‘0Åñ'ð¬Éd	oepÝ°4DÐÜÊ¦q(~ÀÌ ê\r‚E°ÛprùQVFHœl£‚Kj¦¿äN&­j!ÍH`‚_bh\r1Ž ºn!ÍÉŽ­z™°¡ð¥Í\\«¬\rŠíŠÃ`V_kÚÃ\"\\×‚'Vˆ«\0Ê¾`ACúÀ±Ï…¦VÆ`\r%¢’ÂÅì¦\rñâƒ‚k@NÀ°üBñíš™¯ ·!È\n’\0Z™6°\$d Œ,%à%laíH×\n‹#¢S\$!\$@¶Ý2±„I\$r€{!±°J‡2HàZM\\ÉÇhb,‡'||cj~gÐr…`¼Ä¼º\$ºÄÂ+êA1ðœE€ÇÀÙ <ÊL¨Ñ\$âY%-FDªŠd€Lç„³ ª\n@’bVfè¾;2_(ëôLÄÐ¿Â²<%@Úœ,\"êdÄÀN‚erô\0æƒ`Ä¤Z€¾4Å'ld9-ò#`äóÅ–…à¶Öãj6ëÆ£ãv ¶àNÕÍf Ö@Ü†“&’B\$å¶(ðZ&„ßó278I à¿àP\rk\\§—2`¶\rdLb@Eöƒ2`P( B'ã€¶€º0²& ô{Â•“§:®ªdBå1ò^Ø‰*\r\0c<K|Ý5sZ¾`ºÀÀO3ê5=@å5ÀC>@ÂW*	=\0N<g¿6s67Sm7u?	{<&LÂ.3~DÄê\rÅš¯x¹í),rîinÅ/ åO\0o{0kÎ]3>m‹”1\0”I@Ô9T34+Ô™@e”GFMCÉ\rE3ËEtm!Û#1ÁD @‚H(‘Ón ÃÆ<g,V`R]@úÂÇÉ3Cr7s~ÅGIói@\0vÂÓ5\rVß'¬ ¤ Î£PÀÔ\râ\$<bÐ%(‡Ddƒ‹PWÄîÐÌbØfO æx\0è} Üâ”lb &‰vj4µLS¼¨Ö´Ô¶5&dsF Mó4ÌÓ\".HËM0ó1uL³\"ÂÂ/J`ò{Çþ§€ÊxÇYu*\"U.I53Q­3Qô»J„”g ’5…sàúŽ&jÑŒ’Õu‚Ù­ÐªGQMTmGBƒtl-cù*±þ\rŠ«Z7Ôõó*hs/RUV·ðôªBŸNËˆ¸ÃóãêÔŠài¨Lk÷.©´Ätì é¾©…rYi”Õé-Sµƒ3Í\\šTëOM^­G>‘ZQjÔ‡™\"¤Ž¬i”ÖMsSãS\$Ib	f²âÑuæ¦´™å:êSB|i¢ YÂ¦ƒà8	vÊ#é”Dª4`‡†.€Ë^óHÅM‰_Õ¼ŠuÀ™UÊz`ZJ	eçºÝ@Ceíëa‰\"mób„6Ô¯JRÂÖ‘T?Ô£XMZÜÍÐ†ÍòpèÒ¶ªQv¯jÿjV¶{¶¼ÅCœ\rµÕ7‰TÊžª úí5{Pö¿]’\rÓ?QàAAÀèŽ‹’Í2ñ¾ “V)Ji£Ü-N99f–l JmÍò;u¨@‚<FþÑ ¾e†j€ÒÄ¦I‰<+CW@ðçÀ¿Z‘lÑ1É<2ÅiFý7`KG˜~L&+NàYtWHé£‘w	Ö•ƒòl€Òs'gÉãq+Lézbiz«ÆÊÅ¢Ð.ÐŠÇzW²Ç ùzd•W¦Û÷¹(y)vÝE4,\0Ô\"d¢¤\$Bã{²Ž!)1U†5bp#Å}m=×È@ˆwÄ	P\0ä\rì¢·‘€`O|ëÆö	œÉüÅõûYôæJÕ‚öE×ÙOuž_§\n`F`È}MÂ.#1á‚¬fì*´Õ¡µ§  ¿zàucû€—³ xfÓ8kZR¯s2Ê‚-†’§Z2­+ŽÊ·¯(åsUõcDòÑ·Êì˜ÝX!àÍuø&-vPÐØ±\0'LïŒX øLÃ¹Œˆo	Ýô>¸ÕŽÓ\r@ÙPõ\rxF×üE€ÌÈ­ï%Àãì®ü=5NÖœƒ¸?„7ùNËÃ…©wŠ`ØhX«98 Ìø¯q¬£zãÏd%6Ì‚tÍ/…•˜ä¬ëLúÍl¾Ê,ÜKa•N~ÏÀÛìú,ÿ'íÇ€M\rf9£w˜!x÷x[ˆÏ‘ØG’8;„xA˜ù-IÌ&5\$–D\$ö¼³%…ØxÑ¬Á”ÈÂ´ÀÂŒ]›¤õ‡&o‰-39ÖLù½zü§y6¹;u¹zZ èÑ8ÿ_•Éx\0D?šX7†™«’y±OY.#3Ÿ8 ™Ç€˜e”Q¨=Ø€*˜™GŒwm ³Ú„Y‘ù ÀÚ]YOY¨F¨íšÙ)„z#\$eŠš)†/Œz?£z;™—Ù¬^ÛúFÒZg¤ù• Ì÷¥™§ƒš`^Úe¡­¦º#§“Øñ”©Žú?œ¸e£€M£Ú3uÌåƒ0¹>Ê\"?Ÿö@×—Xv•\"ç”Œ¹¬¦*Ô¢\r6v~‡ÃOV~&×¨^gü šÄ‘Ùž‡'Î€f6:-Z~¹šO6;zx²;&!Û+{9M³Ù³d¬ \r,9Öí°ä·WÂÆÝ­:ê\rúÙœùã@ç‚+¢·]œÌ-ž[gž™Û‡[s¶[ižÙiÈq››y›éxé+“|7Í{7Ë|w³}„¢›£E–ûW°€Wk¸|JØ¶å‰xmˆ¸q xwyjŸ»˜#³˜e¼ø(²©‰¸ÀßžÃ¾™†ò³ {èßÚ y“ »M»¸´@«æÉ‚“°Y(gÍš-ÿ©º©äí¡š¡ØJ(¥ü@ó…;…yÂ#S¼‡µY„Èp@Ï%èsžúoŸ9;°ê¿ôõ¤¹+¯Ú	¥;«ÁúˆZNÙ¯Âº§„š k¼V§·u‰[ñ¼x…|q’¤ON?€ÉÕ	…`uœ¡6|­|X¹¤­—Ø³|Oìx!ë:¨œÏ—Y]–¬¹Ž™c•¬À\r¹hÍ9nÎÁ¬¬ë€Ï8'—ù‚êà Æ\rS.1¿¢USÈ¸…¼X‰É+ËÉz]ÉµÊ¤?œ©ÊÀCË\r×Ë\\º­¹ø\$Ï`ùÌ)UÌ|Ë¤|Ñ¨x'ÕœØÌäÊ<àÌ™eÎ|êÍ³ç—â’Ìé—LïÏÝMÎy€(Û§ÐlÐº¤O]{Ñ¾×FD®ÕÙ}¡yu‹ÑÄ’ß,XL\\ÆxÆÈ;U×ÉWt€vŸÄ\\OxWJ9È’×R5·WiMi[‡Kˆ€f(\0æ¾dÄšÒè¿©´\rìMÄáÈÙ7¿;ÈÃÆóÒñçÓ6‰KÊ¦Iª\rÄÜÃxv\r²V3ÕÛßÉ±.ÌàRùÂþÉá|Ÿá¾^2‰^0ß¾\$ QÍä[ã¿D÷áÜ£å>1'^X~t1\"6Lþ›+þ¾Aàžeá“æÞåI‘ç~Ÿåâ³â³@ßÕ­õpM>Óm<´ÒSKÊç-HÉÀ¼T76ÙSMfg¨=»ÅGPÊ°›PÖ\r¸é>Íö¾¡¥2Sb\$•C[Ø×ï(Ä)žÞ%Q#G`uð°ÇGwp\rkÞKe—zhjÓ“zi(ôèrO«óÄÞÓþØT=·7³òî~ÿ4\"ef›~íd™ôíVÿZ‰š÷U•-ëb'VµJ¹Z7ÛöÂ)T‘£8.<¿RMÿ\$‰žôÛØ'ßbyï\n5øƒÝõ_ŽàwñÎ°íUð’`eiÞ¿J”b©gðuSÍë?Íå`öážì+¾Ïï Mïgè7`ùïí\0¢_Ô-ûŸõ_÷–?õF°\0“õ¸X‚å´’[²¯Jœ8&~D#Áö{P•Øô4Ü—½ù\"›\0ÌÀ€‹ý§ý@Ò“–¥\0F ?* ^ñï¹å¯wëÐž:ð¾uàÏ3xKÍ^ów“¼¨ß¯‰y[Ôž(žæ–µ#¦/zr_”g·æ?¾\0?€1wMR&M¿†ù?¬St€T]Ý´Gõ:I·à¢÷ˆ)‡©Bïˆ‹ vô§’½1ç<ôtÈâ6½:W{ÀŠôx:=Èî‘ƒŒÞšóø:Â!!\0x›Õ˜£÷q&áè0}z\"]ÄÞo•z¥™ÒjÃw×ßÊÚÁ6¸ÒJ¢PÛž[\\ }ûª`S™\0à¤qHMë/7B’€P°ÂÄ]FTã•8S5±/IÑ\rŒ\n îO¯0aQ\n >Ã2­j…;=Ú¬ÛdA=­p£VL)Xõ\nÂ¦`e\$˜TÆ¦QJÍó®ælJïŠÔîÑy„IÞ	ä:ƒÑÄÄBùbPÀ†ûZÍ¸n«ª°ÕU;>_Ñ\n	¾õëÐÌ`–ÔuMòŒ‚‚ÂÖm³ÕóÂLwúB\0\\b8¢MÜ[z‘&©1ý\0ô	¡\r˜TÖ×› €+\\»3ÀPlb4-)%Wd#\nÈårÞåMX\"Ï¡ä(Ei11(b`@fÒ´­ƒSÒóˆjåD†bf£}€rï¾‘ýD‘R1…´bÓ˜AÛïIy\"µWvàÁgC¸IÄJ8z\"P\\i¥\\m~ZR¹¢vî1ZB5IŠÃi@x”†·°-‰uM\njKÕU°h\$o—ˆJÏ¤!ÈL\"#p7\0´ P€\0ŠD÷\$	 GK4eÔÐ\$\nGä?ù3£EAJF4àIp\0«×FŽ4±²<f@ž %q¸<kãw€	àLOp\0‰xÓÇ(	€G>ð@¡ØçÆÆ9\0TÀˆ˜ìGB7 - €žøâG:<Q™ #Ã¨ÓÇ´û1Ï&tz£á0*J=à'‹J>ØßÇ8q¡Ð¥ªà	€OÀ¢XôF´àQ,ÀÊÐ\"9‘®pä*ð66A'ý,y€IF€Rˆ³TˆÏý\"”÷HÀR‚!´j#kyFÀ™àe‘¬z£ëéÈðG\0Žp£‰aJ`C÷iù@œT÷|\n€Ix£K\"­´*¨Tk\$c³òÆ”aAh€“! \"úE\0OdÄSxò\0T	ö\0‚žà!FÜ\n’U“|™#S&		IvL\"”“…ä\$hÐÈÞEAïN\$—%%ù/\nP†1š“²{¤ï) <‡ð L å-R1¤â6‘¶’<@O*\0J@q¹‘Ôª#É@Çµ0\$tƒ|’]ã`»¡ÄŠA]èÍìPá‘€˜CÀp\\pÒ¤\0™ÒÅ7°ÄÖ@9©bmˆr¶oÛC+Ù]¥JrÔfü¶\rì)d¤’Ñœ­^hßI\\Î. g–Ê>¥Í×8ŒÞÀ'–HÀf™rJÒ[rçoã¥¯.¹v„½ï#„#yR·+©yËÖ^òù›†F\0á±™]!É•ÒÞ”++Ù_Ë,©\0<@€M-¤2WòâÙR,c•Œœe2Ä*@\0êP €Âc°a0Ç\\PÁŠˆO ø`I_2Qs\$´w£¿=:Îz\0)Ì`ÌhŠÂ–Áƒˆç¢\nJ@@Ê«–\0šø 6qT¯å‡4J%•N-ºm¤Äåã.É‹%*cnäËNç6\"\rÍ‘¸òè—ûŠfÒAµÁ„põMÛ€I7\0™MÈ>lO›4ÅS	7™cÍì€\"ìß§\0å“6îps…–ÄÝåy.´ã	ò¦ñRKð•PAo1FÂtIÄb*ÉÁ<‡©ý@¾7ÐË‚p,ï0NÅ÷: ¨N²m ,xO%è!‚Úv³¨˜ gz(ÐM´óÀIÃà	à~yËö›h\0U:éØOZyA8<2§²ð¸ÊusÞ~lòÆÎEð˜O”0±Ÿ0]'…>¡ÝÉŒ:ÜêÅ;°/€ÂwÒôäì'~3GÎ–~Ó­äþ§c.	þ„òvT\0cØt'Ó;P²\$À\$ø€‚Ð-‚s³òe|º!•@dÐObwÓæc¢õ'Ó@`P\"xôµèÀ0O™5´/|ãU{:b©R\"û0…Ñˆk˜Ðâ`BD\nk€Pãc©á4ä^ p6S`Ü\$ëf;Î7µ?lsÅÀß†gDÊ'4Xja	A‡…E%™	86b¡:qr\r±]C8ÊcÀF\n'ÑŒf_9Ã%(¦š*”~ŠãiSèÛÉ@(85 T”Ë[þ†JÚ4I…l=°ŽQÜ\$dÀ®hä@D	-Ù!ü_]ÉÚH–ÆŠ”k6:·Úò\\M-ÌØðò£\r‘FJ>\n.‘”qeGú5QZ´†‹' É¢ž½Û0ŸîzP–à#Å¤øöÖéràÒít½’ÒÏËŽþŠ<QˆT¸£3D\\¹„ÄÓpOE¦%)77–Wt[ºô@¼›Žš\$F)½5qG0«-ÑW´v¢`è°*)RrÕ¨=9qE*K\$g	‚íA!åPjBT:—Kû§!×÷H“ R0?„6¤yA)B@:Q„8B+J5U]`„Ò¬€:£ðå*%Ip9ŒÌ€ÿ`KcQúQ.B”±Ltbª–yJñEê›Té¥õ7•ÎöAmÓä¢•Ku:ŽðSji— 5.q%LiFºšTr¦Ài©ÕKˆÒ¨z—55T%U•‰UÚIÕ‚¦µÕY\"\nSÕm†ÑÄx¨½Ch÷NZ¶UZ”Ä( Bêô\$YËV²ã€u@è”»’¯¢ª|	‚\$\0ÿ\0 oZw2Ò€x2‘ûk\$Á*I6IÒn• •¡ƒI,€ÆQU4ü\n„¢).øQôÖaIá]™À èLâh\"øf¢ÓŠ>˜:Z¥>L¡`n˜Ø¶Õì7”VLZu”…e¨ëXúè†ºB¿¬¥B‰º’¡Z`;®ø•J‡]òÑ€žäS8¼«f \nÚ¶ˆ#\$ùjM(¹‘Þ¡”„¬a­Gí§Ì+Aý!èxL/\0)	Cö\nñW@é4€ºáÛ©• ŠÔRZƒ®â =˜Çî8“`²8~â†hÀìP °\r–	°žìD-FyX°+Êf°QSj+Xó|•È9-’øs¬xØü†ê+‰VÉcbpì¿”o6HÐq °³ªÈ@.€˜l 8g½YMŸÖWMPÀªU¡·YLß3PaèH2Ð9©„:¶a²`¬Æd\0à&ê²YìÞY0Ù˜¡¶SŒ-—’%;/‡TÝBS³PÔ%fØÚý• @ßFí¬(´Ö*Ñq +[ƒZ:ÒQY\0Þ´ëJUYÖ“/ý¦†pkzÈˆò€,´ðª‡ƒjÚê€¥W°×´e©JµFèýVBIµ\r£ÆpF›NÙ‚Ö¶™*Õ¨Í3kÚ0§D€{™Ôø`q™•Ò²Bqµe¥D‰cÚÚÔVÃE©‚¬nñ×äFG E›>jîèÐú0g´a|¡Shì7uÂÝ„\$•†ì;aô—7&¡ë°R[WX„ÊØ(qÖ#Œ¬P¹Æä×–Ýc8!°H¸àØVX§ÄŽ­jøÊZŽô‘¡¥°Q,DUaQ±X0‘ÕÕ¨ÀÝËGbÁÜlŠBŠt9-oZü”L÷£¥Â­åpË‡‘x6&¯¯MyÔÏsÒ¿–èð\"ÕÍ€èR‚IWU`c÷°à}l<|Â~Äw\"·ðvI%r+‹Rà¶\n\\ØùÃÑ][‹Ñ6&Á¸ÝÈ­Ãa”ÓºìÅj¹(Ú“ðTÑ“À·C'Š…´ '%de,È\n–FCÅÑe9C¹NäÐ‚-6”UeÈµŒýCX¶ÐV±ƒ¹ýÜ+ÔR+ºØ”Ë•3BÜÚŒJð¢è™œ±æT2 ]ì\0PèaÇt29Ï×(i‹#€aÆ®1\"S…:ö· ˆÖoF)kÙfôòÄÐª\0ÎÓ¿þÕ,ËÕwêƒJ@ìÖVò„Žµéq.e}KmZúÛïå¹XnZ{G-»÷ÕZQº¯Ç}‘Å×¶û6É¸ðµÄ_žØÕ‰à\nÖ@7ß` Õï‹˜C\0]_ ©Êµù¬«ï»}ûGÁWW: fCYk+éÚbÛ¶·¦µ2S,	Ú‹Þ9™\0ï¯+þWÄZ!¯eþ°2ûôà›—í²k.OcƒÖ(vÌ®8œDeG`Û‡ÂŒöL±õ“,ƒdË\"CÊÈÖB-”Ä°(þ„„„p÷íÓp±=àÙü¶!ýk’ØÒÄ¼ï}(ýÑÊB–kr_Rî—Ü¼0Œ8a%Û˜L	\0é†Àñ‰b¥²šñÅþ@×\"ÑÏr,µ0TÛrV>ˆ…ÚÈQŸÐ\"•rÞ÷P‰&3báP²æ- x‚Ò±uW~\"ÿ*èˆžŒNâh—%7²µþK¡Y€€^A÷®úÊC‚èþ»p£áîˆ\0ð..`cÅæ+ÏŠâGJ£¤¸H¿À®E‚…¤¾l@|I#AcâÿD…|+<[c2Ü+*WS<ˆràãg¸ÛÅ}‰Š>iÝ€!`f8ñ€(c¦èÉQý=fñ\nç2Ñc£h4–+q8\na·RãBÜ|°R“×ê¿ÝmµŠ\\qÚõgXÀ –ÏŽ0äXä«`nîF€îìŒO pÈîHòCƒ”jd¡fµßEuDV˜bJÉ¦¿å:±ï€\\¤!mÉ±?,TIa˜†ØaT.L€]“,JŒ?™?Ï”FMct!aÙ§RêF„Gð!¹Aõ“»rrŒ-pŽXŸ·\r»òC^À7áð&ãRé\0ÎÑf²*àA\nõÕ›Háã¤yîY=Çúè…l€<‡¹AÄ_¹è	+‘ÎtAú\0B•<Ay…(fy‹1Îc§O;pèÅá¦`ç’4Ð¡Mìà*œîf†ê 5fvy {?©àË:yøÑ^câÍuœ'‡™€8\0±¼Ó±?«ŠgšÓ‡ 8BÎ&p9ÖO\"zÇõžrs–0ºæB‘!uÍ3™f{×\0£:Á\n@\0ÜÀ£pÙÆ6þv.;àú©„Êb«Æ«:J>Ë‚‰é-ÃBÏhkR`-ÜñÎðawæxEj©…÷Árž8¸\0\\Áïô€\\¸Uhm› ý(mÕH3Ì´í§S™“Áæq\0ùŸNVh³Hy	—»5ãMÍŽe\\g½\nçIP:Sj¦Û¡Ù¶è<Ž¯Ñxó&ŒLÚ¿;nfÍ¶cóq›¦\$fð&lïÍþi³…œàç0%yÎž¾tì/¹÷gUÌ³¬dï\0e:ÃÌhïZ	Ð^ƒ@ç ý1€Ïm#ÑNów@ŒßOððzGÎ\$ò¨¦m6é6}ÙÒÒ‹šX'¥I×i\\QºY€¸4k-.è:yzÑÈÝH¿¦]ææxåGÏÖ3ü¿M\0€£@z7¢„³6¦-DO34Þ‹\0ÎšÄùÎ°t\"Î\"vC\"JfÏRÊžÔúku3™MÎæ~ú¤ÓŽ5V à„j/3úƒÓ@gG›}Dé¾ºBÓNq´Ù=]\$é¿I‡õÓž”3¨x=_j‹XÙ¨fk(C]^jÙMÁÍF«ÕÕ¡ŒàÏ£CzÈÒVœÁ=]&ž\r´A<	æµÂÀÜãç6ÙÔ®¶×´Ý`jk7:gÍî‘4Õ®áë“YZqÖftu|hÈZÒÒ6µ­iã€°0 ?éõéª­{-7_:°×ÞtÑ¯íck‹`YÍØ&“´éIõlP`:íô j­{hì=Ðf	àÃ[byž¢Ê€oÐ‹B°RS—€¼B6°À^@'4æø1UÛDq}ìÃNÚ(Xô6j}¬cà{@8ãòð,À	ÏPFCàð‰Bà\$mv˜¨Pæ\"ºÛLöÕCS³]›ÝàEÙÞÏlU†Ñfíwh{o(—ä)è\0@*a1GÄ ( D4-cØóP8£N|R›†âVM¸°×n8G`e}„!}¥€Çp»‡Üòý@_¸ÍÑnCtÂ9ŽÑ\0]»u±î¯s»ŠÝ~èr§»#Cn p;·%‹>wu¸ÞnÃwû¤Ýžê.âà[ÇÝhT÷{¸Ýå€¼	ç¨Ë‡·JðÔÆ—iJÊ6æ€O¾=¡€‡ûæßE”÷Ù´‘ImÛïÚV'É¿@â&‚{ª‘›òö¯µ;íop;^–Ø6Å¶@2ç¯lûÔÞNï·ºMÉ¿r€_Ü°ËÃ´` ì( yß6ç7‘¹ýëîÇ‚“7/Ápðe>|ßà	ø=½]Ðocû‘á&åxNm£‰çƒ»¬ào·GÃN	p—‚»˜x¨•Ã½Ýðƒy\\3àø‡Â€'ÖI`râG÷]Ä¾ñ7ˆ\\7Ú49¡]Å^p‡{<Zá·¸q4™uÎ|ÕÛQÛ™àõp™ýši\$¶@oxñ_<Àæ9pBU\"\0005— iä×‚»¸Cûp´\nôi@‚[ãœÆ4¼jÐ„6bæP„\0Ÿ&F2~ŽÀù£¼ïU&š}¾½¿É˜	™ÌDa<€æzx¶k£ˆ‹=ùñ°r3éË(l_”…FeF›ž4ä1“K	\\ÓŽldî	ä1H\r½€ùp!†%bGæXfÌÀ'\0ÈœØ	'6Àžps_›á\$?0\0’~p(H\n€1…W:9ÕÍ¢¯˜`‹æ:hÇB–èg›BŠk©ÆpÄÆót¼ìˆEBI@<ò%Ã¸Àù` êŠyd\\Y@D–P?Š|+!„áWÀø.:ŸLe€v,Ð>qóAÈçº:ž–îbYéˆ@8Ÿd>r/)ÂBç4ÀÐÎ(·Š`|é¸:t±!«‹Á¨?<¯@ø«’/¥ S’¯P\0Âà>\\æâ |é3ï:VÑuw¥ëçx°(®²Ÿœ4€ÇZjD^´¥¦Lý'¼ìÄC[×'ú°§®éjÂº[ E¸ó uã°{KZ[s„ž€6ˆ‚S1Ìz%1õc™£B4ˆB\n3M`0§;çòÌÂ3Ð.”&?¡ê!YAÀI,)ðå•l†W['ÆÊIÂ‡Tjƒè>F©¼÷S§‡ BÐ±Pá»caþÇŒuï¢NÝÏÀøHÔ	LSôî0”ÕY`ÂÆÈ\"il‘\rçB²ëã/Œôãø%P€ÏÝN”Gô0JÆX\n?aë!Ï3@MæF&Ã³Öþ¿,°\"î€èlbô:KJ\rï`k_êb÷üAáÙÄ¯Ìü1ÑI,ÅÝîüˆ;B,×:ó¾ìY%¼J ŽŠ#v”€'†{ßÑÀã„ž	wx:\ni°¶³’}cÀ°eN®Ñï`!wÆ\0ÄBRU#ØSý!à<`–&v¬<¾&íqOÒ+Î£¥sfL9QÒBÊ‡„ÉóäbÓà_+ï«*€Su>%0€Ž™©…8@l±?’L1po.ÄC&½íÉ BÀÊqh˜¦ó­’Ážz\0±`1á_9ð\"–€è!\$øŒ¶~~-±.¼*3r?øÃ²Àd™s\0ÌõÈ>z\nÈ\0Š0 1Ä~‘ô˜Jð³ðú”|SÞœô k7gé\0ŒúKÔ d¶ÙaÉîPgº%ãw“DôêzmÒûÈõ·)¿‘ñŠœj‹Û×Âÿ`k»ÒQà^ÃÎ1üŒº+Îåœ>/wbüGwOkÃÞÓ_Ù'ƒ¬-CJ¸å7&¨¢ºðEñ\0L\r>™!ÏqÌîÒ7ÝÁ­õoŠ™`9O`ˆàƒ”ö+!}÷P~EåNÈc”öQŸ)ìá#ûï#åò‡€ì‡ÌÑøÀ‘¡¯èJñÄz_u{³ÛK%‘\0=óáOŽX«ß¶Cù>\n²€…|wá?ÆF€Åê„Õa–Ï©UÙåÖb	N¥YïÉhŠ½»é‘/úû)ÞGÎŒ2ü™¢K|ã±y/Ÿ\0éä¿Z”{éßP÷YG¤;õ?Z}T!Þ0ŸÕ=mN¯«úÃfØ\"%4™aö\"!–ÞŸúºµ\0çõï©}»î[òçÜ¾³ëbU}»Ú•mõÖ2±• …ö/tþî‘%#.ÑØ–Äÿse€Bÿp&}[ËŸŽÇ7ã<aùKýïñ8æúP\0™ó¡g¼ò?šù,Ö\0ßßˆr, >¿ŒýWÓþïù/Öþ[™qýk~®CÓ‹4ÛûGŠ¯:„€X÷˜Gúr\0ÉéŸâ¯÷ŸL%VFLUc¯Þä‘¢þŽHÿybP‚Ú'#ÿ×	\0Ð¿ýÏì¹`9Ø9¿~ïò—_¼¬0qä5K-ÙE0àbôÏ­üš¡Žœt`lmêíËÿbŒàÆ˜; ,=˜ 'S‚.bÊçS„¾øCc—ƒêëÊAR,„ƒíÆXŠ@à'…œ8Z0„&ìXnc<<È£ð3\0(ü+*À3·@&\r¸+Ð@h, öò\$O’¸„\0Å’ƒèt+>¬¢‹œbª€Ê°€\r£><]#õ%ƒ;Nìsó®ÅŽ€¢Êð*»ïcû0-@®ªLì >½Yp#Ð-†f0îÃÊ±aª,>»Ü`ÆÅàPà:9ŒŒo·ð°ov¹R)e\0Ú¢\\²°Áµ\nr{Ã®X™ÒøÎ:A*ÛÇ.Dõº7Ž»¼ò#,ûN¸\rŽE™Ô÷hQK2»Ý©¥½zÀ>P@°°¦	T<ÒÊ=¡:òÀ°XÁGJ<°GAfõ&×A^pã`©ÀÐ{ûÔ0`¼:ûð€);U !Ðe\0î£½Ïc†p\r‹³ ‹¾:(ø•@…%2	S¯\$Y«Ý3é¯hCÖì™:O˜#ÏÁLóï/šé‚ç¬k,†¯Kåoo7¥BD0{ƒ¡jó ìj&X2Ú«{¯}„RÏx¤ÂvÁä÷Ø£À9Aë¸¶¾0‰;0õá‘à-€5„ˆ/”<Üç° ¾NÜ8E¯‘—Ç	+ãÐ…ÂPd¡‚;ªÃÀ*nŸ¼&²8/jX°\rš>	PÏW>Kà•O’¢VÄ/”¬U\n<°¥\0Ù\nIk@Šºã¦ƒ[àÈÏ¦Â²œ#Ž?€Ùã%ñƒ‚èË.\0001\0ø¡kè`1T· ©„¾ë‚Él¼šÀ£îÅp®¢°Á¤³¬³…< .£>íØ5ŽÐ\0ä»	O¬>k@Bn¾Š<\"i%•>œºzÄ–ç“ñáºÇ3ÙPƒ!ð\rÀ\"¬ã¬\r ‰>šadàöó¢U?ÚÇ”3P×Áj3£ä°‘>;Óä¡¿>žt6Ë2ä[ÂðÞ¾M\r >°º\0äìP®‚·Bè«Oe*Rn¬§œy;« 8\0ÈËÕoæ½0ýÓøiÂøþ3Ê€2@Êýà£î¯?xô[÷€ÛÃLÿaŽ¯ƒw\ns÷ˆ‡ŒA²¿x\r[Ñaª6Âclc=¶Ê¼X0§z/>+šª‰øW[´o2ÂøŒ)eî2þHQPéDY“zG4#YD…ö…ºp)	ºHúpŽ˜&â4*@†/:˜	á‰T˜	­Ÿ¦aH5‘ƒëh.ƒA>œï`;.Ÿ­îY“Áa	Âòút/ =3…°BnhD?(\n€!ÄBúsš\0ØÌDÑ&D“J‘)\0‡jÅQÄyŽhDh(ôK‘/!Ð>®h,=Ûõ±†ãtJ€+¡Sõ±,\"M¸Ä¿´NÑ1¿[;øÐ¢Š¼+õ±#<ìŒI¤ZÄŸŒP‘)ÄáLJñDéìP1\$Äîõ¼Q‘>dO‘¼vé#˜/mh8881N:øZ0ZŠÁèT •BóCÇq3%°¤@¡\0Øï\"ñXD	à3\0•!\\ì8#h¼vìibÏ‚T€!dª—ˆÎüV\\2óÀSëÅÅ’\nA+Í½pšxÈiD(ìº(à<*öÚ+ÅÕE·ÌT®¾ BèS·CÈ¿T´æÙÄ e„Aï’\"á|©u¼v8ÄT\0002‘@8D^ooƒ‚ø÷‘|”Nù˜ô¥ÊJ8[¬Ï3ÄÂõîJz×³WL\0¶\0ž€È†8×:y,Ï6&@”À E£Ê¯Ý‘h;¼!f˜¼.Bþ;:ÃÊÎ[Z3¥™Â«‚ðn»ìëÈ‘­éA¨’ÓqP4,„óºXc8^»Ä`×ƒ‚ôl.®üº¢S±hÞ”°‚O+ª%P#Î¡\n?ÛÜIB½ÊeË‘O\\]ÎÂ6ö#û¦Û½Ø(!c) Nõ¸ºÑ?EØ”B##D íDdo½åPAª\0€:ÜnÂÆŸ€`  ÚèQ„³>!\r6¨\0€‰V%cbHF×)¤m&\0B¨2Ií5’Ù#]ú˜ØD>¬ì3<\n:MLðÉ9CñÊ˜0ãë\0“¨(á©H\nþ€¦ºM€\"GR\n@éø`[Ãó€Š˜\ni*\0œð)ˆü€‚ìu©)¤«Hp\0€Nˆ	À\"€®N:9qÛ.\r!´JÖÔ{,Û'æÙŠ4…B†úÇlqÅ¨ŸXc«Â4ß‹N1É¨5«WmÇ3\nÁF€„`­'‘ˆÒŠxàƒ&>z>N¬\$4?ó›ÃïÂ(\nì€¨>à	ëÏµPÔ!CqÍŒ¼Œp­qGLqqöG²yÍH.«^àž\0zÕ\$€AT9Fs†Ð…¢D{ía§øcc_€GÈz†)ó³‡ Ü}QÆÅhóÌHBÖ¸<‚y!L­“€Û!\\‚²ˆî ø'’H(‚ä-µ\"ƒin]Äžˆ³­\\¨!Ú`M˜H,gÈŽí»*ÒKfë*\0ò>Â€6¶ˆà6ÈÖ2óhJæ7Ù{nqÂ8àßôÉHÕ#cHã#˜\r’:¶–7Ê8àÜ€Z²˜ZrD£þß²`rG\0äl\n®Iˆi\0<±äãô\0Lg…~¨ÃE¬Û\$¹ÒP“\$Š@ÒPÆ¼T03ÉHGH±lÉQ%*\"N?ë%œ–	€Î\nñCrWÉC\$¬–pñ%‰uR`ÀË%³òR\$–<‘`ÖIfxª¯÷\$/\$„”¥\$œš’O…(‹Ë\0æË\0RY‚*Ù/	ê\rÜœC9€ï&hhá=IÓ'\$–RRIÇ'\\•a=EÔ„òuÂ·'Ì™wIå'T’€€‘üÿ©¾ãK9%˜d¢´·‚!ü”ÀÊÊÀÒj…ì¡íÓÊ&Ðæ„vÌŸ²\\=<,œEùŒ`ÛYÁò\\Ÿ²‚¤*b0>²r®à,d–pdŒŒÌ0DD Ì–`â,T ­1Ý% P‘ž¤/ø\ròb¹(Œ£õJÑèÍîT0ò``Æ¾ÞèíóJ”t©’©ÊŸ((dÇÊªáh+ <Éˆ+H%i‡Èô‹²•#´`­ ÚÊÑ'ô£B>t˜¯J€Z\\‘`<Jç+hR·ÊÔ8î‰€àhR±,J]gò¨Iä•è0\n%J¹*ÐY²¯£JwDœ°&Ê–D±®•ÉÐœªR§K\"ß1Qò¨Ë ”²AJKC,ä´mV’»Ž²›ÊÙ-±òÏKI*±r¨ƒ\0ÇL³\"ÆKb(üªóJ:qKr·dùÊŸ-)ÁžË†#Ô¸²Þ¸[ºA»@•.[–Ò¨Ê¼ß4º¡¯.™1ò®J½.Ì®¦u#J“‡Ág\0Æãò‘§£<Ë&”’ðK¤+½	M?Í/d£Ê%'/›¿2YÈä>­\$Í¬lº\0†©+ø—Á‰}-tº’Í…*ê‰Rä\$ß”òÌK».´Á­óJHûÊ‰‡2\r„¿B‚½(PÍÓÌ6\"ü–nf†\0#Ð‡ ®Í%\$ÄÊ[€\nÐnoLJ°ŒÅÓÂe'<¯ó…‡1KíÁyÌY1¤Çs¥0À&zLf#üÆ³/%y-²Ë£3-„Â’ÍK£L¶ÎÉ×0œ³’ë¸[,¤ËÌµ,œ±’«„§0”±Ó(‹.DÀ¡@ÏÁ2ïL+.|£’÷¤É2è(³L¥*´¹S:\0Ù3´ÌíóG3lÌÁaËl³@L³3z4­Ç½%Ì’ÍLÝ3»…³¼!0Š33=Lù4|È—¡à+\"°Êé4´Ëå7Ë,\$¬SPM‘\\±Î?JŠY“Ì¡¹½+(Âa=K¨ì4œ¤³CÌ¤<Ð…=\$,»³UJ]5h³W &tÖI%€é5¬Ò³\\M38g¢Í5HŠN?W1Hš±^ÊÙÔ¸“YÍ—Ø Í.‚N3MŸ4Ã…³`„Ži/P‰7ÖdM>šd¯/LRÎÜâ=K‘60>¯I\0[ðõ\0ßÍ\r2ôÔòZ@Ï1„Û2ÿ°7È9äFG+ä¯ÒœÅ\r)àhQtL}8\$ÊBeC#Á“r*HÈÛ«Ž-›Hý/ØËÒ6Èß\$øRC9ÂØ¨!‚€Å7ük/PË0Xr5ƒ¡3D„¼<TÁÔ’q¯Kô©³nÎH§<µFÿ:1SLÎrÀ%(ÿu)¸Xr—1Ñ€nJÃIÌ´S£\$\$é.Î‡9Ôé²IÎŸÒ3 ¨LÃl”“¯Î™9äÅC•N #Ô¡ó\$µ/ÔésÉ9«@6Êt“²®Nñ9¼´·NÉ:¹’Â¡7ó Ó¬Í:DáÓÁM)<#–ÓÃM}+ñ2ÎNþñ²›O&„ð¢JNy*ŒòòÙ¸[;ñóÎO\"mÚÄóÅMõ<c Â´‚°±8¬K²,´ÓÇN£=07s×JE=Tá³ÆO<Ôô³£Jé=D“Ó:ÏC<Ì“àË‰=äèó®KÊ»Ì³ÈL3¬÷­„LTÐ€3ÊS,œ.¨ÿÏq-Œñsç7Í>‚?ó¼7O;Ü `ùOA9´óñÏ»\$œüÁOÑ;ìý`9ÎnÇIAŒxpÜöE=O¹<ü²5ÏÎ„ý2¸O?d´Ž„´Œ`NòiOÿ>Œþ3½P	?¤òÔOžmœúSðMôË¬·†=¹(ãdã¤AÈ­9“‘\0í#üä²@ƒ­9DŽÁÉ&ÜýòŠ‚?œ “Ði9»\nà/€ñAÝóòÈ­A¤ýSËPo?kuN5¨~4ÜãÆ6††Ø=ò–Œ“*@(®N\0\\Û”dGåüp#è¤> 0À«\$2“4z )À`ÂW˜ð +\0Š‘80£è¦• ¤ª”äz\"TÐä0Ô:\0Š\ne \$€ŽrM”=¡r\n²N‰P÷Cmt80ðú #¤ØJ= &ÐÆ3\0*€Bú6€\"€ˆéèú€#Ì>˜	 (Q\nŒðê´8Ñ1C\rt2ƒECˆ\n`(Çx?j8N¹\0¨È[À¤QN>£©à'\0¬x	cêªð\nÉ3×Chü`&\0²Ð´8Ñ\0ø\näµ¦úO`/€„¢A`#ÐìXcèÐÏD ÿtR\n>¼ÔdÑBòD´LÐÄÌõ‰äÐÍDt4ÐÖ j”pµGAoQoG8,-sÑÖðÔK#‡);§E5´TQÑGÐ4Ao\0 >ðtMÓD8yRG@'PõC°	ô<PõCå\"”K\0’xüÔ~\0ªei9Ðìœv))ÑµGb6‰€±H\r48Ñ@‚M‰:€³FØtQÒ!H•”{R} ôURpÍÔO\0¥I…t8¤ØðûÎÇ[D4FÑD#ÊÑ+D½'ôMÊ•À>RgIÕ´ŠQïJ¨””UÒ)EmàüTZ­Eµ'ãê£iEÝ´£ÒqFzAªº>ý)T‹Q3HÅ#TLÒqIjNT½¼…&CøÒhX\nT›ÑÙK\0000´5€ˆ¢JHÑ\0“FE@'Ñ™Fp´hS5F\"ÎoÑ®e%aoS E)  €“DU «Q—FmÎÑ£M´ÑÑ²e(tnÒ “U1Ü£~>\$ñßÇ‚’­(hÕÇ‘Güy`«\0’ê 	ƒíG„ò3Ô5Sp(ýõPãGí\$”œ#¤¨	©†©N¨\nôV\$ö]ÔœPÖ=\"RÓ¨?Lzt·ƒ1L\$\0ÔøG~å ,‰KNý=”ëÒGMÅ”…¤NS€)ÑáO]:ÔŠS}Ý81àRGe@Cí\0«OPðSõNÍ1ôÝT!P•@ÑÝS€ðÿÕS‰G`\nÉ:€“P°j”7R€ @3üÑ\n‘ üã÷â£”DÓ æúLÈÏ¼Ž 	èë\0ùQ5ôµ©CPúµSMP´v4†º?h	hëT‡D0úÑÖàõ>&ÒITxôO¼?•@U¤÷R8@%Ô–ŒõK‰€§NåKãóRyE­E#ýù @ýÃøä%Là«Q«Q¨µ£ª?N5\0¥R\0úÔTëFåÔ”RŸSí!oTEÂC(Ï¶ÈýÄµ\0„?3iîSS@U÷QeMµƒ	KØ\n4PÕCeS”‘\0NC«P‚­Oõ! \"RTûõ€S¥NÕÁU5OU>UiIÕPU#UnKPô£UYTè*ÕC«U¥/\0+º¸Å)ÈÚ:ReAà\$\0øŽ¤xòÇWDº3Ãêà`üÚüçU5ÒIHUY”ô:°P	õe\0–MJi€ƒµÃýQø>õ@«T±C{›ÕuÑì?Õ^µv\0WR]U}Cöê1-5+Uä?í\rõW<¸?5•JU-SXüÕLÔß \\tÕ?ÒsMÕb„ÕƒVÜt§TŒ>ÂMU+Ö	EÅcˆÏÔ9Nm\rRÇƒCý8ŽSÇX•'RÒéXjCI#G|¥!QÙGh•tðQ¸ý )<¹YÐ*ÔÐRmX0üôö½M£›õOQßYýhÀ«ßduÕ¤ÕZ(ýAo#¥NlyN¬V€Z9IÕºM•¦V«ZuOÕ…TÕTÅEÕ‡Ö·SÍeµµÖÊ\nµXµªSÛQERµ³ÔÙ[MF±VçO=/õ­¨>õgÕ¹TíVoUT³Z’N€*T\\*ÃïÐ×S-pµSÕÃVÕq€ÒM(ÏQ=\\-UUUV­C•Ä×ZØ\nu’V\$?M@UÎWJ\r\rUÐÔ\\å'U×W]…W”£W8ºN '#h=oCóÐýF(üé:9ÕYu•†¤÷V-UÓ9Ÿ]ÒC©:U¿\\\nµqW—™à(TT?5Páª\$ R3ÕâºŸC}`>\0®E]ˆ#Rêà	ƒÿ#R¥)²W–’:`#óGõ)4ŠRÀý;õáViD%8À)Ç“^¥Qõé#”h	´HÂŽX	ƒþ\$Nýx´š#i xûÔ’XRõ€'Ô9`m\\©†¨\nEÀ¦Q±`¥bu@×ñN¥dT×#YYý„µ®GV]j5#?L¤xt/#¬”å#é…½O­PÕëQæ¢6•££Ï^í† €šŽðüÖØM\\R5t´Óšpà*€ƒXˆV\"WÅD€	oRALm\rdGN	ÕÖÀú6”p\$PåºŸE5Ôý†©Tx\n€+€‹C[¨ôVŽŒýÖ8U•Du}Ø»F\$.ªËQ-;4È€±NX\n.XñbÍ•\0¯b¥)–#­NýG4KØÐZS”^×´M¶8Øód­\"C‚¬>ÅÕdHe\nöY8¥Ñ.ê ú°ˆÒFúD”½W1cZ6”›QâKHü@*\0¿^¸úÖ\\QßF‚4U3Y|‘=˜Ó¤éE›ÔÛ¤¦?-™47YƒPm™hYw_\ršVe×±M˜±ßÙe(0¶ÔFÕ\r !ÒPUI•uÑ7Qå•CèÑŽ?0ÿµÝgu\rqà¤§Y-Qèó°èú=g\0…\0M#÷U×S5Zt®ÖŸae^•\$>²ArV¯_\r;tî¬’¨”HW©Zí@HÕØhzDèÚ\0«S2Jµ HIåO 'ÇeígÉ6¹[µR”<¸?È /ÒKM¤ö–Ø\n>½¤HáZ!iˆö¤ŸTX6–Ò×iºC !Ó›g½à ÒG }Q6žÑ4>äwà!Ú™C}§VBÖ>åªUQÚ‘jª8cïUTàû–'<‚>ÈýõôHC]¨VšÑ7jj3v¥¤å`0ÃèÈ23ö°Ðòxû@U—k \n€:Si5žÕ#Yì-wî”ÕàéM?céÒMQÅGQÕÑƒb`•ò\0Ž@õËÒ§\0M¥à)ZrKXûÖŸÙWl­²öÍlå³TM×D\r4—QsS¥40ÑsQÌõmYãh•d¶ÂC`{›V€gEÈ\n–»XkÕà'Óè,4ú¼¹^í¢6Æ#<4éNXnM):¹·OM_6d€–æõ¸Ãõ[\"KU²nžÖ?l´x\0&\0¿R56ŸT~> ô†Õ¸?”Jnž€’ ˆÏZ/iÒ6ôÎÚglÍ¦ÖUÛáF}´.ž£¼JLöCTbMŽ4ÍÓcLõTjSD’}JtŒ€Z›ªµÇ:±L­€´d:‰Ez”Ê¤ª>ÖV\$2>­µŽ¢[ãpâ6öÔRŽ9uêW.?•1®£RHužèÛR¸?58Ô®¤íDÝÆuƒ£çpûcìZà?œr×» Eaf°}5wY´ëå‚Ï’ÒêÅW‚wT[Sp7'Ô_aEk \"[/i¥¿#ÿ\$;m…fØ£WOüô”ÔFò\r%\$Íju-t#<Å!·\n:«KEA£íÒÑ]À\nUæQ­KEÀ #€¿Xå¨÷5[Ê>ˆ`/£ÍDµÊÖ­VEpà)åI%ÏqßÜûníx):¤§le¢´Õ[eÕ\\•eV[j…–£éÑ7 -+ÖßGWEwt¯WkEÅ~uìQ/mõ#ÔW—`ýyu“Ç£DÝAö'×±\r±•Õ™OD )ZM^€³u-|v8]‹g½‘hö×ÅLà–W\0øÈû6ËX†‘=YÔd½Q­7Ï“”Ï9£çÍ²r <ÃÖêD³ºB`c 9¿’È`D¬=wx©I%ä,á„¬†è²àêƒj[ÑšÖíßOÿ‹´ ``ŽÅ|¸òòÆÞø¤Œ˜¼í.Ì	AOŠÀÄ	·‰@å@ 0h2í\\âÐ€M{eã€9^>ô•â@7\0òôË‚W’€ò\$,íÉÅš¡@Ø€Òâ•å×w^fmå‰,\0ÏyD,×^X€.¯Ö†©7ã·›Ã×2ÝÅf;¥€6«\n”¤Ž…^ŸzC©×§mz…én–^ˆô”&LFFê,°ö[€¥eÈõaXy9h€!:zÍ9còQ9bÅ !€¦µGw_WÉg¥9©ÓS+t®ÚápÝtÉƒ\nm+–œÞÙ_ð	¡ª\\¼’k5£ÒÜ]Æ4ˆ_h•9 Ù÷N…—Å]%|¥ˆ7ËÖœŽ];”ï|ñµ ßXýÍ9Õ|åñ×ÌG¢“¨[×Ô\0‘}Uñ”çßMCI:ÒqO¨VÔƒa\0\rñRÍ6Ï€Ã\0ø@H¢ÅP+rìS¤Wãè€øp7äI~p/ø HÏ^Ýê²ü¤¬E§-%û¥Ì»Í&.ÎÄ+¸JÑ’;:³¶«!“ýÐNð	Æ~öª‰€/“WÄÂ!„BèL+Â\$ðíq§=ü¿+Ñ`/Æ„e„\\±ÒÏxÀpE‘lpSÂJSÝ¢½ö6à‡_¹(Å¯©Äéb\\OÆÊ&ì¼\\Ð59\0ûÂ€9nñøD¸{¡\$á¸‹K‘v2	d]èv…CÕþÅÕ?tf|WÜ:£Ô¨p&¿àLn„Îè³žî{;ˆçÚGR9øT.y¹üïI8€¹´\rl° ú	Tè n”3¼öðT.ƒ9´è3› š¼Zès¡¯ÑÒGñþŽˆ:	0£¦£zè­Ý.Œ]ÀçÄ£Q›?àgT»%ñ™ÕxŒÕŒ.„šÔÇn<ì£-â8BË³,Bòì˜rgQþ¢íßó„ÉŽ`Úá2é„:îµ½{…gëÄs„øgóZ¿•… ×Œ<æ×w{¦˜ƒbU9ˆ	`5`4„\0BxMpð‘8qnahé†@Ø¼í†-â(—>S|0®…¾¥…3á8h\0Ñ«µCÔzLQž@¶\n?†¸`AÀ >2šÂ,÷á˜ñN&Œ«xˆl8sah1è|˜B‡É‡DxBÞ#V—‹V–×Š`Wâa'@›‡¬	X_?\nì¾  •_â. ØP¼r2®bUarÀI¸~áñ…S“àú\0×…\" 2€ÖþÀ>b;…vPh{[°7a`Ë\0êË²j—oŒ~·ûþvÍÙ|fv†4[½\$¶«{ó¯P\rvæBKGbpëÈÅø™–OŠ5Ý 2\0j÷Ù„LŽ€î)ÇmáÈV¡ejBB.'R{C¤ïV'`Ø‚ ‰Ž%­Ç€Ð\$ Oå\0˜`‚’«4 ÌNò>;4£³¢/ÌÏ€´À*Âø\\5„ÅÁ!†û`X*Þ%îÄNÍ3SõAMôþËÆ”,þ1¬²®í\\¯²caÏ§ ³ù@Ø¬Ëƒ¸B/„¬Íø0`óv2ï¡„§Œ`hDÅJO\$ç…@p!9˜!¥\n1ø7pB,>8F4¯åf Ï€:“ñ7Â„î3›£3…¿à°T8—=+~Øn«Îâ\\Äe¸<br·þ øFØ²° ¹C¡N‹:c€:Ôl–<\r›ã\\3à>ñ˜‡À6ONnŠä!;áñ@›twë^Fé€Là;€×º,^aÈ\ra\"ÞÀÚ®'ú:„vàJe4Ã×;•ñ_d\r4\rÌ:ÛüÀ¬S˜à2€[c€„XÿÊ¦Pl˜\$¹Þ£i“wåd#ŽB šb›Î×¤õ’™`:†€Ï~ <\0Ñ2Ù·—‘RŒÂÆPÈ\r¸J8D¡t@ìEŽè\0\rÍœ6öóäÞ7•½ä˜YÏ£ú\"åäÀš\rüƒ¦Àš3ƒ¡.˜+«z3±;_ÊŸvLÝäÓwJ¿94ÀIJa,A¦ñˆ¯;ƒs?ÖN\nR‡!Ž§Ý†Om…sÈ_æà-zÛ­w„€ÛzÜ­7¡ÍÅzî÷–M”ˆ€o¿”¥æ\0¢ƒa”ÅÝ¹4å8èPfñYå?”òi—–eBÎSà1\0ÉjDTeK”®UYSå?66R	¦cõ6Ry[c÷”°5Ù]BÍ”ÖRù_eA)&ù[å‡•XYRW–6VYaeU•fYeåw•ŽU¹båw”Eë°Ê†;z¤^W«9–ä×§äÝ–õë\0<Þ˜èeê9SåÎ¤daª	”_-îá‰L×8Ç…ÍQöèTH[!<p\0£”Py5ˆ|—#ê‘P³	×9vàš2Â|Ç¸áfao†á,j8×\$A@kñƒ¿ŽaË‘½bócñÈf4!4¨‘¶cr,;™‘æ‘öbÆ=€Â;\0°øÅº…˜†cdÃæX¾bìx™a™Rx0Aãh£+wðxN[˜ÜB·pÚƒ¿w™TÀ8T%™šMšl2à‡½¡šð—}¡Ès.kY„˜0\$/èfU€=þØs„gKÃ¡ˆM› õ?ÿ›ç`4c.Ôø!¡&€åˆ†g°ûfà/þf1=¯›V AE<#Ì¹¡f\n») Šë›Npò“ã`.\"\"»Açœ¤ã—üq¸X“ Ù¬:aÉ8™¹f¯™Vsó‹G™ÞrŽ:æVÞÆcÔgVl™g=`ã“WŽËýyÒgUÀË™ªáº¼îeT= ã€á€Æx 0â M¼@ˆ»šÂ%Îºb½œþw™ÆfÛÙOøç­˜Ü*0¯…®|tá°%±™PÈÍpæúgKžù¬?pô@JÀ<BÙŸ#­`1„î9þ2çg¶!3~ØÜçînläÅfŠØVhù¬Ž.Ñ€à…aCÑù•?³Šû-à1œ68>A¤ˆaÈ\r—¦y‹0 Öi‘J«} à¹© Ðz:\r¡)‘Sþ‚¡@¢åh@äöƒY¹ã´mCEg¡cyÏ†‚<õàÍh@¼@«zh<WÙÄ`Â•¨±:zOãÎÖ\rÍêW«“°V08Ùf7™(Gyƒ²`St#ï„f†#ƒ²œC(9ÈÂ˜Ø€dùææ8T:¯»Œ0ºè qµ  79·á£phAgÜ6Š.ãæ7Fr™bä ÈjšèA5î…†ƒá¡a1úÚh•ZCh:–%¹ÎgU¢ðD9ÖÅÉˆ„×¹Ïé0~vTi;VvSš„wœØ\rÎƒ?àÇf²£…ÿ¥nŠÏ›iY™ìaº¬3 Î‡9Õ,\n™Ãr‘‰,/,@.:èY>&…šFÑ)ú™¶}šb£€èiOÝiæš:dèAŒn˜šc=¤L9O’h{¦ 8hY.’ÙÀ®¾‡®‡…œüÇ\r¬Ö‡£À›Šé1Q¯U	”C‘hô†eÿO‰›°+2oÌÎìÞN‹˜÷§øzpè¢(þ]Óh€å¢Z|¬O¡cÑzDáþ;õT\0j¡\0…8#>ÎŽÁ=bZ8Fjóìé;íÞºTé…¡w®Í)¦ýøN`æë¨¤Ã…B{ûƒz\ró¡c“Óè|dTG“iœ/ûú!i†Ê0±¼ø'`Z:ŠCHï(8Âê`V¥™Úãöª\0Üê§©†£WïßÇª˜ÕzgG¾‘…ƒ½²-[ÃÐ	iœêN\rqºé«n„„“o	Æ¥fEJý¡apb¹ê}6£…Õ=o¤–„,tèY+ö®EC\rÖPx4=¼¾™Ù@‡‰¦.†‘F£[¡zqçÜèX6:FG¨ #°û\$@&­ab¤þhE:²ƒå¬ä`¶S­1—1g1©þ„2uhY‹¬_:Bß¡dcï–*ÿ­†\0úÆ—FYFœ:Ë£ªn„ØÌ=Û¨H*Z¼Mhk/ëƒ¡žzÙ¹ï‹´]šÁh@ôæ©Øã1\0˜øZKùž¢ëÎÆè^+º,vfós®š>ˆ¤’Oã|èÀÊsÃ\0Öœ5öXé‹îÑ¯F„÷n¿Aˆr]|ÏIi4è…þ ØÂC° h@Ø¹´Ÿž–cß¥¨6smOÃå‰™›gX¬V2¦6g?~ÖÃYÕÑ°†súcl \\RŠ\0Œ¨cœA+Œ1°„›ùÌé\n(ÑúÃÌ^368cz:=z÷‚(äø ;è£¨ñsüF¶@`;ì€,>yTßï&–•d½L×Ÿœÿ%Òƒ-ëCHL8\r‡Çbû°°£úMj]4Ym9üÛüÐZÚBøïP}<ŸûàX²¯‰Ì¥á+gÅ^ØMÞ + B_Fd¬X„ø‹lówÈ~î\râ½‹è\":ÔêqA1X¾ìæ²Ðø¯3ÖÎ“Eáh±4ßZZÂó¸& …ææ1~!Nfã´öo—ˆ™\nMeÜà¬„îëXIÎ„íG@V*X¯†;µY5{Vˆ\nè»ÏTéz\rF 3}m¶Ôp1í[€>©tèe¶w™Ÿæë@VÖz#‚2Äï	iôôÎ{ã9ƒ‚pÌ»gh‘Šæ+[elU‰¦ÛAßÙ¶Ó¼i1Ä!Œ¾ommµ*Kà‡ê}¶°!íÆ³í¡®Ý{me·f`“—mè˜CÛz=žnÞ:}g° T›mLu1FÜÚ}=8¸ZáíèOžÛmFFMf¤…OO€ðîáÀ‹ƒèøß/¼éõ¸Þ“šå€þV™oqj³²èn!+½òµüZ¨ËI¹.Ì9!nG¹\\„›3a¹~…O+Îå::îK@Œ\nÚ@ƒ‘¤Hph‘´\\BÄõdmfvCèžÓPÛ\" æ½Û.nW&–ên¢øHYþ+\r¶“Äz÷i>MfqÛ¤î­ºùÝQc‚[­H+æÀo¤Ñ*ú1'¤÷#ÄEw€D_Xí)>Ðs£„-~\rT=½£žà÷ˆà- íy§m§¹æð{„hóŸÌjÚMè)€^ž¹ïÀ'@Vå¡+iÈîÎò›Ÿåµ†É;F“ D[Îb!¼¾´B	¦¤:MP‹îóÛ­oC¼vAE?éC²IiYÍ„#þp¶P\$kâJÞq½.É07œþöxˆl¦sC|ï½¾bo–2äXª>Mô\rl&»Ç:2ã~ÛÑcQ²îò²æoÑÞdá‚-þèUÜRo‚YšnM;’n©#–ß\0–P¾fðÚPo×¿(CÚv<Ê¬ø[òoÛ¸”šû×fÑ¿ÖüÁ;ßáº–õ[úYŸ.o®Up¿®pUŒø”.ž ©B!'\0‹òã<Tñ:1±À¾ šã¤î<„›ðnˆîF³ðƒI¢Ç”´‚V0ÊÇRO8‰wøÎ,aFú¼É¥¹[´ÎŸ…ñYOù«‰€/\0™Ùox÷ÇQð?§°:Ù‹ëÆè`h@:ƒ«¿öÑ/Mím¼x:Û°c1¤Öàû¯ív²;„‚è^æØÆ@®õ@£úð½ÂÇ\n{¯¼Âî‹à;ç‘´B¼í¸8‘º gå’ä\\*gåyC)Û„E^ýOÄh	¡³¦Aƒu>Æèü@àDÌ†Yæ¼í›â`o»<>Àƒp‰™ŠÄ·’q,Y1Q¨Áß¸†/qgŒ\0+\0âæå‡Dÿƒç?¶þ î©Úßîk:ù\$©û¬í×¥6~I¥…=@ŽíÑ!¾ùvÚzOñš²â+ÍõÆ9Çi³–›¼aïð†êû…gòðôî¿—¹ÿ?š0Gn˜q²]{Ò¸,FáÃøO¡â„Þ <_>f+¢,ñÌ	»Ôñ±&ôœ†ðíÂ·¼yêÇ©Oü:¬UÂ¯ˆLÆ\nÃÃºI:2³¿-;_Ä¢È|%éå´¿!Îõfž\$¦ˆ†Xr\"Kniîñ—ÀÐ\$8#›g¤t-›€r@LÓåœè@S£<‘rN\nD/rLdQkà£“”ªõÄîeðåäãÐ­åø\n=4)ƒB˜”Ë×šôÌZ-|Hb¡†‘HkÊ*	ÖQ!Ð'êG ž›Ybt!¿Ê(n,ìP³OfqÑ+X“Y±ÿ‚ë\"b F6ÖÌr fò\"ÒÜ³!N¡ó^¼¦r±B_(í\"¨KÊ_-<µò *Q÷ò¨Ù/,)H\0„‰²rç\"z2(¹tÙ‡.F>†‡#3â®Ø¦268shÙ þ¨Æ‘I1Sn20¶çÊ-«4’ÚÇ2Aœs(¬4ä¼Ë¶Š\0ÆÝ#„årþK'ËÍ·G'—7&\n>xßüÜJØGO8,ó…0¼â‹ù8”ÑÓ\0óW9’ÝIˆ?:3nº\r-w:³ÂÌÅ×;3È‰”!Ï;³Üêƒ˜˜Z’RMƒ+>ÖÜðÊé0/=R…'1Ï4Õ8ûÑÏmÿ%È¥}Ï‡9»;‚=ÏnQöã=ÏhhLõ·GÏkWÎ\rô	%Ø4ÒœsñÎ–J€3sÛ4—@™U‚%\$ÜÑN;Ì?4­»óNÚÏ2|ÊóZÚ3Øh\0Ï3“5€^Àxi2d\r|ûM·Ê£bh|Ý#vÇ` \0”ê®äàû\$\r2h#ú¤?³ˆI\n’¼+o-œŠ?6`á¹½¿.\$µšøKY%ØÂJ?¦c°RN#K:°KáELÁ>:Á¥@ŒãjP‘Ìn_t&slm’'æÐ©É¸Óœ²Œ½—ã;6Û—HU5#ìQ7U ýWYÜU bNµ–Wû_ûª©;TCø[Ý<Ú–>ÅÇõ‰WýCUÔ6X#`MI:tùÓµ€ö	u#`­fu«\$«t­öXó`f<Ô;båghöÑÕ9×7ØS58õ¬Ý#^–-õ\0êÀúîÕ¹R*Ö'£¨(õðõqZå££êX¹QÝFUvÔW GWíñÓTêÇWô~Ú­^§WöÄÁÕýJ=_Ø—bmÖÝbV\\l·/ÚMÕÿTmTOXuÊ=_ýITvvu‹a\rL_ÕqR/]]mÒsu=H=uÑg o\\UÕ…gM×	XVU À%õhý¡53U™\\=¡öQßØM¹v‡€¡gåmàõue¡ˆÙûhÿbÝMÝGCeO5®ÔÖO5…ÔYÙi=eÕ	GTURvOa°*ÝivWX•J5<õ¯bu ]ˆ×Öðúµ<õÃÙÕ\$u3v#×'eöuÑR5m•Šv‹D5.vŽŒõW=ŸU_å(´\\VØÏ_<õ÷SÍn)Ü1M%QháZ‡T…f5EÕ'ÕÍW½ŠvÅUmiÕ‚UÔÕ]aW©U§dRváÙ-YUZuÙUV—UiRV™õ³ÓÇ[£íZMU§\\=Âv{ÛXýµ¼wQ÷huHvÇ×gqÝ´w!Úoqt¢U{TGqý{÷#^G_ubQ„êå•i9Qb>ÚNUdº±k…½5hPÙmu[•\0¦êÅ_¶é[õY-ðô÷rõÈÕ(ÖCrMeýJõ!h?QrX3 xÿÈÏ#‡÷xÖ<Û{u5~ƒíÑ-ÝuŽëYyQ\r-”î\0ùuÕ£uuÙ¿pUÚ…•)–PåÜ\r<u«S›0ÝÉw¹ß-iÝóÔ!ÌÖŠøB÷áÆd]ùèÅ‡ÔÆEêðvlmQÝ6k¼ÒJ´ˆwí¦ÄžØÃãŒED¶UÙR“ev:XßcØNW}`-¨tÓH#e„bº±u€ãó	~B7ê ?ƒ	OPœCWµ×SEÍ•V>¶“×UÛ7ßžç‰Ôám»Ó‚¬zÿ=µƒÍØ1º™ƒ+ ¹mÃI,>µX7àä] .‡½*	^îŠã°N…º.èÎ/\"„˜)Ð	…¯‚sž®|à¤çÓŸÐlÁ}ã¸ŽÍç!óîƒ‘5n±p„j£¾h’}½èðm“EázHÂaO0d=A|wëß³ãë×šÎìu²œŸvùØ¼G€x#®…b”cSðo-‰ùtOm`C‹ò^MŒÅ@ë´h­n\$k´`þ`HD^PEà[äŒ]¹¨rR¸mž=‚.ñÙ‡>Ayi‚ \"ú€ò	Ö·oã-,.œ\nq+À¥åfXdŠ«¶ã*ß½ˆKÎØƒ'Üê Ð%aôÿ‡ù9pûæ—øKLM„à!þ,èÊËŽ¨ŒzX#˜Vá†uH%!Àœ63œJ¾ryÕíùq_èu	úWù±‡Æ|@3b1åÈ7|~wï±³þíA7“ÒÂ›è™	¼™9cS&{ãäÒ%VxðïkZO‰×w‰Ur?®„’ªN Î|…CÉ#Å°õåÕ¯ ¹/ú™9ftŽEw¸CÁºa¦^\0øO<þW¦{Yã=éŸeë˜ýnÉ„ígyf0h@ìSÝ\0:C©´^€¸VgpE9:85Ã3æÞ§áºð@»áŽj_ª[Þ+«êÇ©xƒ^“ê®†~@Ñ‡Wª¸ãã“œ†9x—FC˜¿­.ãšçöük^IŽû¡pU9üØSŸØ÷½—œ\$óóø\r4´…ù\0ÎèO°ã‘Ä)L[Âp?ì.PECSìI1nm{Å?žPîWAß²Á;€ñìD°;SºaKføò›%?´XõÞ+¤B>½ù9¿¯ÙGj˜cžz‘AÍŽ÷:êa³n0bJ{o¥·!3À­!'’ØKÃÅíùÔ}ã\\èÎ3Wøê5îxÏÉÁL;ƒ2Î¶n—a;²í×ºXÓ›]Éoºœxû{ä¦5Þ™jX÷ˆð—¶vÓšéãqÞÊEE{Ñ€4Á¾öÄ{íÙç	Ì\nöÊ>ù™aï¯·¾üì§ïØLûÔûåïÿ½ûìñ'ð½Þé{ë\n‰—>JøßŒŒá¸Ó—†÷YÏ\rOÊ½ð‘t¯ÿû¥-OÃ¦ü4Ôÿ9Fü;ð§Á»ÔüGðøIªFßì1ÂoÿßóñO²¾éa{w—0Ó»ï¤Æ¯;ñ”„‘lüoñàJÐTb\rwÇ2®Jµþ=D#ònÁ:ÉyñûSø^ã,.¿?(ÈI\$¯ÊÆ¯í¨á3÷Ãsð4MÊaCRÉÆÍGÌ‘œúIß°n<ûzyÑXN¾ð?õâ.Ãî=—àñ´DÇ¼\r›žØé\nÕó¨\roõý\nÐŸCl%ÁÍYÎû¥ß°ÏàGÑþÚ}#VÐ%ý(ÔÿÒà3æÉ˜ržð};ôû×¿GÉÌnö[ª{¥¹–“_<m4[	I¥¢À¼q°µ?ð0cVýnms„³nMõõˆ\"Nj1õw?@ì\$1¦þ>ðÒ^øÕû¥ö\\Ì{nÂ\\Ìžé7Ÿ„¿ÙŸic1ïÚÿhooê·?j<GöxŸlÏù©Sèr}ÍÃÚ|\"}•÷/Ú?sç¬tIäåê¼&^ý1eóÓtãô,*'F¸ß=/Fkþ,95rVâáøàÀºì‘ˆÛo9Íø/FÀ–_†~*^×ã{ÐIÆö¯ã_ƒ‚²Œ“^n„øþNŸŠ~øáÅAí¦‘d©åñþUøwäqY±åî´T¸2ÀéGä?‡&–§æô:yùè%Ÿ–Xç˜JÛCþd	WèßŽ~úG!†´J}›—¤úìùõÄB-Óï±;îûœhÃ*ó¼R´ìöE¶ ~âæó.«~Éçæ SAqDVxÂîÍ='íÉEÙ(^Šû¢~›ùø¿›çòéçïo7~‚M[§Qãî(³Üy¸ùnPÑ>[WX{qÔaÏ¤ÆÉý.&NÚ3]ñúHYïÝûƒëÛ[¶ÁÙ&ü8?Ñ3„‹›¦¶§Ý†Ú»¶á#Œ¦ÎBðe6ë…@–“[°¤£ûàÐG\rÎ+ý§}ü˜÷ÁÿÏ_Ýç7–|N„§«Þ4~(zÁ~“»¹ï§%›–?±ßÓÈ[¹ø1žSª]xØköÑKxO^éA€‰rZ+ºÿ»½*ÂWö¯kþwD(¹ø»R:æý\0•§íù'¤Šó“m!OÐ\näÅuè‚Æó.[ PÆ!¹²}×Ïm Ûï1pñuüâ,T©çL 	Â€0}â&PÙ¥\n€=Dÿ=¾ñÐ\rÂšA/·o@äü2ãt 6àDK³¶\0ÈÂƒq†7„l ¼ðBêŠúÌ(ƒ;[ñˆkr\r‘;#‘ÃäƒlÅ”\r³<}zb+ÔÐOñ[€WrXƒ`Z Å£†Pm'Fn ¼‰îSpß-°\0005À`d¨Ø÷P„ÁÚÇ¾·Û;²Ìn\0‚5fïP„¿EJäwûÛ ¹.?À;¶§NòÞ¥,;Æ¦Ï-[7·ÞeþÚiÅâ-“ÖîdÙŽ<[~”6k:&Ð.7‡]\0ó©ûë–ù/µ59 ñÁ@eT:ç…˜¯3ÅdsÝú5äœ5f\0ÐPµöHB–•í°½º8JÔLS\0vI\0ˆ™Ç7DmÆaž3e×íŽ?B³ª\$´.E‹ÐfË@ªnúƒ‰bòGbÁÏq3Ÿ|üšPaËˆøÏ¯X7Tg>Â.ÚpØï™’5¸«AHÅµ’Š3Sð,˜Á@Ô#&wµî3†ôm[ÏÀòIíÑ¥Ó^“Ì¤J1?©gTá½#ÏS±=_„‚_±	«£ÉVq/CÛ¾·Ý€Î|ËôáþD ƒg>Ü„õëé 6\rŠ7}q”ÆÅ¤‹JGïB^î†\\g´Ýõüœ&%­Ø[ª2IxÃ¬ªñ6\03]Á3Œ{É@RUàÙMö v<å1Š¿‘¾sz±uP’5ŸªF:Òiî|À`­qÓ÷†V| »¦\nkâ}Ð'|Žgd†!¨8¦ <,ëP7˜m¦»||»ÿ¶IŽAÓ]BB ÏFö0XÏú³	ŠDÖß`W µÁqm¦OL‘	ì¸.Í(Áp‚¼Òä¶\"!‹ýª\0âÍAïÃô‡‰ÁV€–7kƒŒM¸\$ÓN0\\Õ§ƒ\"‹f‘á Çëñ È\0uqž—,Œ 5ÆãA6×pÎÎÈ\nðÎjY³7[pK°ð4;lœ5n©Á@â\\fûÐl	¦‚MöùûPÁç3®—C HbÐŒ©¸cEpP‰ÚÐ4eooeù{\r-àš2.ÔÖ¥½ŒP50uÁ²°G}Äâ\0îËõ¨<\röœ!¸œ~Êýµ¾óñ¹\n7F®d¶ýà“œ>·Ôa¢Ù%ºc6Ôž§õMÀ¥|òàd‹û·ìOÓ_¨?J„æªC0Ä>ÐÁ&7kM4ª`%fílðÎ˜B~¢wxÑÚZGéP†2¯à0ü=ž*pð†@ˆBeÈ”ØÏ|2Ä\r³?q¸Ð8í¸ë±ñÍÐŠ(·yráö 0àî>œ>ÀE?wÜ|r]Ö%AvàýÁÅä@Ž+ÝXÁªAgâÉÛÿsû®CÐûAXmNÒú4\0\rÚÍ½8JÝJðÇ¸DÒšó´:=	•ðó‡ëÆS™4¯ñF;	¬\\&Öè†P!6%\$iäxi4c½0Bá;62=ÚÛ1ÂùÌˆPCØåÂƒmËÍ“dpc+Ò5Šå\$/rCR†`£MQ¤6(\\á2A ¦¹\\ªŒlGòl¬\0Bq°¤P¯r²ûøBµ‰ê›Ñ‚¹_6LlË!BQŽ‰IÂŽGÀåÜØðXRbs¡]B—Hržã˜`ÎX‹ä\$på±8ð„•	nbR,Â±…L \"ÂE%\0’aYB¦sœ…ÍD,!Æ×Ï›pN9RbG·4ÆþM¬Œt…¸œ¬jUô¤À§y\0ìÝ%\$.˜iL!xÂìÒ“Å(Ä.‘)6T(’I…ìa%ÒKÈ]mÄt¥ô…ú&‚óG7ÇITMóBú\rzaÂØ])vaˆ%œ†²41TÁjÍ¹(!…¬Þ¡¨\\\\ÆWÂÜ\\t\$¤0Åæ%á”\0aK\$èTšF(YàC@‚ºHÏŽÐHã€nD’dÃ†Wp˜ÉhZ¯'áZC,/Ž¡\$û¦£—J¡FB¨uÜ¬Q:Î¥ÂAö‰:-a#”ì=jb¨§lÕUg;{R°€Uº±EWnÔUa»Vâî•Nj¬§u‹GÉ*¨yÖ¹%ÝÒ@Åï*Ìä«ÕYxê±_ó²§z€]ë)v\"£çRÕåL¯VIvê=`›¾'ª°UÝ) S\r~R˜•™\ni”Å)5S¦åD49~Êb”;)3‡,¦9M3¯HsJkTœÃœ‡(¢†ú—uJ‰][\$uf¨íob£µ¹\n.,îYÜµ9j1'µŒ!ö1\$J¶‘gÚ¤ÕŸÄ†U0­ÓZuah£±·cH¥,ÃYt²ñKbö5—ë5–’/dY¬³AUšÒ…©‹[W>¨_Vÿ\rˆ‘*·õ©j£§-T±… zÖYÊd•c®m‡Ò¹±Ø:¹€üË[Ut-{ªµýl	£i+a)».[º•_:Ú5žähƒò­WÂ§Ém»¥%JI‘´[T«h>š®µ·°•™;ËXÌºdêÂŸS›d‰Væ;\rÆ±!Nˆ“K&—AˆJu4B…ÁdgÎ¢.Vp¢ámb‹…)ÇV!U\0Gä¸¨“`‹Ð­\\…qâŸ7Qöb«VL¥Þ:äÕ‚úƒó¬Z.­Nò˜Ä*–ÔU]Z´læzë…Îöù®ÇR D1IŸåÂ£Ñr:\0<1~;#ÀJbà¦ÊM˜yÝ+™Û”/\"Ï›j<3æ#“–ÌŒêñ¡…:P.}êe÷ïòD\"qÙyJýGŒû·sopŒ¯²þXŒ\rÝ³d–Þ\rxJ%–í‰ÏÆ¼O:%yyãÅ,‡”%{Î3<îXÃ¸ÏÌ÷¯zÂEÎz(\0 €D_÷½Ÿ.2+Ög®bºcÚxìpgÞ¨Áß|9CPŽûî˜48U	Q§/Aq®ÝQ¼(4 7e\$D“‰v:ŒV¡b×ûN4[ùˆiv°Àê2ñ\r•X1¼˜AJ(<PlFÐ\0¾¨€\\zÝ)ÑçšW€(ü4ôÈÃÚï¢ p•™ÓõÊ`µÇ\r³da6”¯üOÖímña´}qÅ`ÂÀ6Pƒ'hàç3§|š’îÃf jÈÿAæƒz‰ø£+ŒDŒUWøDíþÞ5ÅÄ%#é°x“3{«¶L\r-Í™]:jd×P	jüf½q:Z÷\"sadÒ)óGØ3	¤+ðŠr„NKö1Qþ½ç†x=>û\"¤°-á:ÊFÍõœIÙƒ*í@ÔŸÇy»Tí\\Uè¨ãŠY~ÂŠ‰Žäâš‚3Då€Á™ã¨f,s¢8HV¯'Ét9v(:ÖB9ñ\\Zš¡…(‘&‚E8¯ƒÍW\$X\0»\nŒž9«WBÀ’bÁÃ66j9Ð âÊˆ„ƒ?,š¬| ùa¾g1²\nPs \0@%#K„¸€ \r\0Å§\0çˆÀ0ä?ÀÅ¡,ä\0ÔhµÑh€\08\0l\0Ö-ÜZ±jbàÅ¬\0p\0Þ-Ùf`ql¢ä€0\0i-Ü\\ps¢è€7‹e\"-ZðlbßEÑ,ä\0ÈÌ]P ¢ÚE¶‹b\0Ú/,Zðà\rÀ\0000‹[f-@\rÓ¯EÚ‹Ï/„Z8½‘~\"ÚÅÚ‹­ö.^ÒÎQw€ÅÏ‹‚\0Ö/t_È¼ÀâèEð‹Ö\0æ0d]µ€búÅ¤‹|\0ÈÄ\\Ø¼‚¢íE¤\0af0tZÀÑnJô\0l\0Î0L^˜´Qj@ÅáŒJˆ´^¸¹q#F(Œ1º/ì[µ1Š¢ãÆŒIæ.Ü^8»\0[ŒqØÌ[Ã‘l\"åÆ Œ€\0æ0,dè¶À€Æ\rŒÌ„cøµ{cEÁ\0oâ0¬]°\0\rc%ÅÛ‹—ðˆ8½w¢åÆZ‹µ-Ä\\ºñ{ãÅÖ‹Gª/\\bp„…@1Æ\0a²1ù‹ÈÏÑsã!Å¨Œ/î/Ì]8¹‘~c\"ÅÛ‹Åþ2ôcÎ‘m£\"€9Œqš/\\^fQ~cÆ_‹£Î-\$iž\"Ö\0003ŒË¬¤fXºqx#\09Œ—Z.´i¸ÈŒ@FˆŒ‰3tZHÉ \rcK€b\0j’/DjøÉ1¨ââÆIh´aÈñv€Æ©OZ4œZòÌÑ‚#YE¨\0i–.hHÒÑsX/F<‹Ï†.äjøËñ­bèÆÍ\0mV/d\\èØñ‹b÷E³‹£ž3T^(ÝÑˆcKFR‹Õù‚ô]X¶q½¢øÅà—’6Ô]hÓñžc6EÄ‹ó66Üh‘Ÿãn\0005sn/dn¸Ô`\r\"ÑFŒ³Ú-D`ÈÕ‘‹ãN€2‹Y”¤bxÀñ”#\\Åë‹‡V3x·1x€FxŒ¾\0Ê6Œb°q£ƒÇ!Žž8|^‚ÌÑubåÆàÕ-ôrØäq¼ã:ÆéŽ%ö0Œppñ”#Ç‹¢\0Æ6ÔfÕÑÇ¢âÅ¬dÒ0„qH´±¾£\$Ç@‹qò-¼^B4±¦\"ú\08Ž1ª/lnxÏ‘ âêG3:0tjhÒ~@Æ¼Ž¥¦3¤vHÆñ¹bÜG(Že„4gØºqÂã2Æ1ŒÉ-ŒnXËñº\"ãF<Qž1\\j¸¸1®ãÈEÇ‹Çä³4m¨Õñªã[ô‹nÁz7üyhÞ1§#ÆÞŽ/‚3\\xÐqÍKG‚ŒÿÆ6äo˜Ñ1{£°FJ×š6¼lXéqâ£„Æu©Þ9œr(¿1Òã‡Gc\0Åf:„rX½ #ÐÅ½\0iÞ<\\}×ñåbîF½\0sÖ7Üy2ÌÑæ#uFe›\">4iØÅ¿âÔÆçŒé\n<{¸ã‘£âÆ‰ŒJ;¬]ØÄ1Å#ÎÆ0ÙJ;4^èÂD½ãóÇ®‹Ÿ¨³4i¨À(H#ÚÆEŒx–/¤nøû1ðã/Ç¡‹åj6,l˜Û1tã/\0005%ï0„]xü‘¶£GG5!’0¤€¨×ñÚâé–rŒq¢2Ì¨Þ‘ÎãNFPo\"4ô_˜·1×dÇ%‹e ²3¬s8é‘üã†G5Ž“ æ6Ô[Hë“cØHjYš;ô[è¾‘˜bë! Žyò@Ä\\¸½qØ#WHN‡Ž;ÌcÆQèã:Ç-%ª.œkXÆ‘ý£ÚGÍŒÏ†1Df¨ß‘ºcWFl¡!‚0ü€™²c EÜ©Ž;l˜Ñq\"ëF©ß¢7\\\\¨ùñâ£ÔÆO‹qþ.T|\"?‘ñã™ÆE³f9TyYÑ©ãSG1ûÂA\$f9R\n\"ÞÆxŒ¹>Bœ…HÚñß¤\0ÇŒ¶:\$e¹1œ£³F?=º3Tu)\nq¹béÇ~ËÎ<TøÎ±Ðc‰H.‘m~CôwHÊ±¸#/ÈI]~3ä^ˆºÑ„#§Æ>‘Y®4Œ^¸ÎQjcÊÇKŒ1\"Ò8¬|6Ñåc\"ÇB‘µ\"b4ãèæ%œ¢ÔÈG\0e\"’/t‹¨´1r£1Æe!v2„yÀ±õä<Ç †8\\o¨ÊÑ’#tÅÑ\rz@´}HÂ‘èbïÆèy î1Ì\\¨ðëdeGŽÁZ3Œ~ér)ã1È¿‹Û†Bl~H½²:£dF£‘-Î?”k8´qèc(FÍ‹ŠKÞ5|myñ€c1Æ<’*@´jØáò1ãÛÅ¾Œ‹>I´ZèÍQjä•È2ŒÉ\$0¤‹hµQˆäVFTŒ	\$ÆAl~öqÚ£È±Ž\$Ö>\\pÙ\rq‚\$/Èu%ï!®Jq \$ ãtE²‹GN-Tq)ò\"¢ÛHÊŒË¦=ì–XÉ2-£H’«š8\\nˆµRW\$HŒë\"¢C\\_¹\0»d\$Çf‘³\".D„u	'Q£zEíŒÙ&0toˆóqjãúÆ¿Œ³R@d—øÉä£ùÇu##¶LLkÉ*qó\$*GÄ‘iÎ@TŠi‘lãòEª‘ƒÎ5Œ˜¾r\\d–I–‘µ\"/ÌZÉ0’j\$TÅþŒz5Ld3’£ëÉ’oÂ.Tq¹!1{£Æ‹åÖ9œZ¸¾QÕbÓFŒwJ94nˆÒÄÖä{É(“-Ž8·2h¤uÈé“;\$†-Dkøårs£‡Hž™#¡‚ôY7ò\"Ø/E¿’Ó 	\$j¢^ò-£]Ç7Ž[\"N\$’èÂ‘“¤WÈ‘¯Ö/]à\$²+€1Ga/&IDnøÂ’@\$åÆ!‹ç\$Î-Œk!Q¨âùÊ)(N/\$t¸Ý¹äëÆOKzP´tXÜò[\0’GŽ’w(*K\$vˆË1ócÉ'“ÞGÌžIòxd­È\n“AÒ8\\rX·Òa£÷I”iNœI%\$½ã’Æ_‘÷ª6¤fçQþ#–ÈI”5#ŽF´—ØºñÏ#³Eâ’•\"î3\$¢IÜc‡Hˆ‹ÝvR|ùQ€¤cE¸ñ:R„eº±hä¶EÎfK`8þr.#·E³s®0L…˜üRä†F©‹·!\nC\$`Èöñ´\$ôH?’ËnPÜe™!ñš¥@F'”¿–/œ‡¸¶ÄÖäÿÊ”¯%ÂN,hÈÌrF\$öÈþŒÇ3´tøæÒ€¥Åæ’!1<„ÉCQÏ%ÉÃ’¹æJäZØf.Ý6Å†œ·±C‰¥ÊÔœ.²[þ™BÒ¿xëàƒè\0NRn`šÈùY\n’%+N¨IMs:Ã¹Ydƒef¬B[¶°ÝnÆ¹YŠòm¨ÁR®×’ûÉY¯ÚC„XŒëÛj³çU+Vk,¯\0Pëýb@e²¹¥x¬„V¾ºyT¤7ˆuî«[Jï•È±\nD¯§eR¿¬mx&°lÀ\0)Œ}ÚJ¼,\0„IØZÆµ\$k!µ¨ñYb²Áœ°€RÂ‡e/Q¾Àk°5.Áe‘­5•À¨žW‘`ª¥\0)€Yv\"VÂ\0•Ã\n‡%—å–`Yn¯Õ¡aôÔxÃ†Q!,õ`\"‰	_.Ÿå©Æ–tm\$•\"“²J«¤ÖÀ§ŽvÆ%‰M9j‚°	æ–§Ä*³KpÖ”’;\\R ¼ü3(§õŠ^¯:}–Èï|>Âµa-'U%w*‰#>¤@Ì¬e–Jÿ¤;Pw/+¹á5E\rjn¡ÐÃd–ô¢^[ú¯§cÎ°¥uËz\\Ø1mi\"x‚„påÃ;£ÌîˆæˆP)äøªÇ#„±Ø’¡…Ë!Aª;¨ß	4ì³a{`aV{KUàÊ8ã¨Ÿ0''o€2ˆ¨¢ycÌ¸9]Ké@ºÒ—^ðlBˆâOrëÔã,du¤¾8¤?õ‰€Õ%¼gB»ˆî‚ÆYn+ã%c¬e\0Œ°ñà¤±Yr@fì‹(]Ö¼¨\nbizîÖn€SS2£ÁGdBPjŠ¹Ö@€(—È¥¦!à-çv²´eÚ*c\0„ª4Jæç‚’ùÕÙ,“UÈ	dºÉeðj'TˆH]ÔŠÔG!œ)u‹ÕÖ¯Ÿ•Ò¯ùZËB5ûÌ“WŽ‰0\n±á¡ÔR«ÁW…\\¦Q jÄ^rÊ%lÌ˜3,ÒYy×Éf3&Ì•ÜŽÕQ:Ïµ2„mÉR)”T€¾(KRÁ 0ªÊ”@«ìY´¢Y:£Ùe3\r%´¨°Tö%­X”Á¹‡STÔ.J\\ë0ÙhôÄ…ŠD!Ä:—uæêÉU\"¾ÅÁo+7–\"„µ“f'º­R\0°‘ÞJõ2S–2è#nm »ÁIåŠœý\"Xü³²[Ö€Ñì} J¨¯c¼9p0ªüÕQ»(U\0£xDEW‚Œ.LõÁ=<BÔ0+½)ZS V;â\\âµI{5I‘AôÖÃ,dW²uè5Ew\n\$%Ò…ˆ½2i_\$ÈÙ+ìæO,Œ¬‡íX‹´Õ‘Jg&J¡úG’º%\\J“·b.ÄÝ^L‹TòFlŒè–¹]k#f@L·G€ÄT¼Ù—ÒÍHÏÌ\"–q1SÌ°ù‰jVÉ(Î™„ìZVzßÅ†³,§ÊèG.1Fû±gNÊ;×1ÃŠV¬¦5EÍò5`ò\0Ctè=F\ná¹›Î±•K‡þ™Ö\0­ÛŠ±%¨ËD]Q\$\r\0‡3J\\,Í™š³<T4*£™Á.ÒYK²D«QƒéLïS%,ŠgÔÇåª§Ö<Ëë™u0–ôÍUÄ‰Ö*x(©åNÂ’Yv!þ¥yÍ	wÅ4fdª¥rG•‰M \$äê‰^;ºéîÝæˆ)<Pã]DÒ%%Ó;ÔjÊåšI0æaÓu^Jp—[)¦v©3RhRúEöÀ\næ–L_š#5|Ü¾Õm3Pñ*¨\\Y51X’’	i³N—Èñ\$\"°ºaü­õh*KUÝÌïV8¨åuò±%&„ræ¯Ëš ²5oŒÕçg³;ÝrMl[Æ¨ögœ³ùª’·UÍq™ê¹šh|ÔeO2·f MlW2AP„×¹˜’ÍÀÍv~eD¬eñ3UÓ«l‡E62iüÎõìÓUbÌï˜¬«õUŒ¬©¨îøýªVðêiI!\$i¨Ê­&Z:½–xm!Å†“.ÖOÍfwÒ¯!”ÌÓkÝ¤Íƒ™6b\"«I™J]]:T™6ÒVrú¹}’ÜÇ«]™®±‘U¢Ž	ys7fÔMÅ™ÿ3ˆŒÜÎYœó:T_MÍw%3ÆnÏ¥\nÎæz*™í3âhƒ·	»`U–²Lÿš‡,¥Û„Ð5¨óvfƒ»Ã›Ù42_Q‰¼hÝÇÍuD§\no£¹)¤ÄœÕ«M9¿7foÛ¼©¤rÖÝÇÎWB~iTÝeyQTâN\nšd¦pr§#›óM§;’˜…4æpª¼„têÿ–(;š›³5	|¬àÇ‚Š­',AV7Ü”ÔåUAö&ìÍRœP¯\"äÕy‡Ò·•‰) [ŠnÌÕñ-3V•Ë,?œs6ºpŠù†3ŽfµÎAšÛ9k|ÝÉ®S†f¬*@œ•5Þg¼¾É¿2·Í}œŒ®þUüÝ™‘ðùæHÎF›l%®pÂ«Ie³be—MÙSO\rŽ[¼æi²3fÉÎLVá®rÙu®Š¾¥ÛNA›:î%r„Úy3Q_Ì¸›W.ÑÕÈ^Sl@&ÌÁ5ÖYlÂÌ1åæÎ}VxêžgÊ…§^SnÕÌÍQ!:5×ZÞiZCÔˆ:¿›•3qgé%DáõÝª{U¡3’tZ¹`ûÓu%w:ÉZQ:QìÏÇW fî‡í›¿9Jplê)Ö3xÔvÌþK7žb#«ù½«çX+Jš(¢Âh´ìP*Ó´«Î›þ¢!×”ìÅSLçh*'¤¨\npBù™ÚªgNÊ§8BuÒªéÂŽ¯çÎŒ½8niêˆIÍs¸USÍIš‡;vvÚ³UõsR•7Nu×8©H|íéÅÓ·§ÌŽœ«8òq´ÕÙÞ+'ÑßÍ`œx¢9Rˆ	Õ®ºçMaR8úxä)¸'!Ïœ;±U¬×YÖ“’ÝsNIg:ÕKTëy¯3®gŽÍYìëÊkäãÉÜ³n'LO(œ¿3šw4ñ4î»¦ÇÏœÚêþl¬ñÎJ½–ªw½9Ý\\ìç•óóhf(¢_~ìòà}9Nö¦Õ\0–´åb\"¢Yé¤ƒTh,Úž¤@ú±D¡û€\$€Iž·;ŽeüèUÊn¨³ž·,¹OªÆ	Xÿg´-ÀžÉ+>ti'G‚öŽlª%\0­8âVBËU1«ye\0KTÆ4ûÁÈm’ºV2)\r]I/\rFù…ÔXˆ×Àß¨ña·­GŠÂ¹ò*ˆ§»žÿ>ERì÷ðî®¥ž‡ÑZ›-)I\$®¹íç:¦aË\0¾FybaÙg«w§­(ß_@§v}öiõÊ³î€S^Ë25DÔ³Ð	ÈôURO±ŸJHÖ\\ØisðfÆËKšN±€qi÷Sg×OÂŸ\n²F~|«µÏ*@gR€_Q<9sÜ¬3i+Ø—².Cw²²ê|‚øyË6aìOÜY9¶Œ¶É–\nëÔ½-([®±†_ˆ}íSû]c¤S=Â¤ÎÙþÎÍÔYÎàU-> <ú©µ\n<ÖsOôQ4F¦^}\0007uäk(/‹ŸÛ/5{Lÿ9µ\0§¬Ð &³Š[<ÏõŸsÛ\0&Íè#…@hÌéª3©V}ÐH¢Š*Üw+]'DÐ& @§Ö])µè;TGe3\\Îên®ÑßËd\$:¦uN4Åyktê-dR!7–­Ée4(P!•Ÿ-þ9À4ç_PMGbÄ±w…«ØÉ6O§S¦F‚âí)§Šyh0+€ž²§qT|·Š+uÔÿÎ+ A¬?òÞ	öTè3.q 41T´¸e›€\n:P ø¯–{Tî\n³ëh?«šTïAùS£­*«åÒ+åu¥>ú\\ê¾ZéíÊîYì·¢wEJö%·’s—L±¾dªšyÀ+\rCèœß¡'Añl,Òyå3þç²ËÍ—`º	_*ÑPû ThKDV²·–~5	à0´+á¼,š-?­]œºò3ëÖKå—`¯^†¸¤I42(]ªwž.æ†rÄÊËê]¬\nYÆ¨B†£­Ð	³í–}Ð‹R ¾ÉgØ}:H§ðJÄWP²ê„\"Þµ—ðôV\\¬<——? >½å—áÿ§Ü¬Ý†¿=¦…:Ÿ\n0×è\\+ñS–´æfÝUŒ³í‰U,…WCÖˆè•On¨òÎ…¢§.†e9|R÷I'©[×/º²ÄÙü2ù›«QžÓBn:ÆIõ\nö§g¼9Æ\rü,ÓR6³ýçÒQ\$XÝ+¸>–©±`\nù)/_8QiÔùµê—=‡êv?5v\0 \n¨çÉLG¥Dmˆw\\ëFÖŒ‡Ñ¢¯ÁdêŸµ}s‰\"‘ÃYv¤|â™J*´9h­¡Ñ@XEUÑ*Þ(oQ]\$Bžˆ,ûéÜƒ•KTœv¤AptCÉƒ\n×C,/˜<¡­Ú™EW‹-VïP¡¢=Wÿ*%Kê—-Q`9	(Êú59Ó€èm)ËX¸¨@ç2ø ýT@ˆÛ\nS–¯‘bd×EÎ´a€+€DXîá|UÚ	‹	’¡F® 2ú%5\nj•m«€WÙ+xêKŒæVÌ3#„¶CTÃek¤™–&Î,£l¬jbd7)Ó“\"\n+ìPüºb’èIŠ@è3Ñ•ÜµjUÒÌEsÞÔ)D¢fë’ƒõŠû•ÇPZ3AÎŒÕ\nwThð—²ªÛ˜Å4Zäª<Êuß©ßdqâËŠu(÷ž“bKG±à¥éÀnÓTï®ˆ]z¨f%#3IËfS¨®&}µ@D†@++ù¤Aíhª¿\nªï€U—Þ¥|B¡;”…UmÑÙU…E•N¥!ôx2±1Ò\0§GmvH~õÁHèTê)öW®³YNý\"åk5©ÑvT#=µÚ¥Ê<\n}‘#R3YƒHÅRÍIÍ³Ü¦;ÌÑRl£1léuB%TQJî™*ºêˆÙ'ºEë0i¬dw,¥zÊÍ¥:\$†¦;Í? üîj‘¿)§ô)ÔÊ\$32J}Å&‡[³\$¨õÌ¤;DnýE×´À+0ÛaZ{¨èC èû€(¤ê:“¸ ÚO@hø²D£æ\0¡‰`PTou“³ÄïF®\rQv‚û¨˜o½Ü¡\$Sîö+˜Ò#7À¤Izr…pk DW”ˆFsÍ9™ Qê  Ð°1€gÀÅ#•\0\\Là\$Ø 3€g©XŽyôy œ-3h›ÀþÃ!†nXèô]+±—	É€c\0È\0¼bØÅ\0\r‰ü‡-{ž\0ºQ(ðQÔ\$s€0…ºém(°[RuòVÆ÷ÒØ>Æ¼+àJ[©6à‘ÒàJ\0Ö—ú\\´¶ã,Òé‚Kš3ý.ê]a_\0RòJ Æ—`š^Ô¶ClRÛIKî–ù\n \$®nÅÒä¥ïKj–©\n€šÁ©~/¥ªmn˜].ª`ô¿ijÒâ¦#K¾˜f:`\0…éŒ€6¦7Kâ–¨zcôÂ\0’Òõ¦/K®–­/ªdôÄé‡FE\0aLŽ˜¤dZ`ƒJé†S‘ÏÊ™…2ØÍ4Î@/Æ(Œ‹Lò™õ0ª`´Ä©†€_ŽLþ™]4ZhôÐ©šSD¦M˜…4:cÑé‹SR¥×M—E4šiò€éžSG¦EMj˜å4zdÔÕ©–SFKLª›%4ªeÔÏ%\$ÓlKM2–õ1ÈÚ”Ôi¦Ó©MV›­.¸Ú”Öi´Ó©Lz›/ˆ÷ôÛ£Ó„¦ÑMæ›,`Š_ôàimSŠ¦gMÆœ€jg‘òéÇÓ5¦9.›…9j_òéºS¥µ.›Å9ê_±òé¾Sˆ¦‹.œ7Úrò)ÉÓ%§[2m8ºuTæé™S±§3M:]3ºq”èänÓ±§KNˆ1|^ÒktÏ\"ÒÓH§gKjž-;zcñiÎÓš§–\r<ê_²-iÊÓ¸¥ñ\"ÖžU.¹´óiëRÚ‘kOFží=:\\ôÏ\$ZÓ©§MLE­5úxôø©ÂÓ»_\"Öœ=<\0ñtéÙSç¦9OÒž­1Š~”öi²Óô§¹Oêí>ê~qœ)òF¸¨’ =6:~ÔõãJÔ‘ÏP:ŸÍ=¨åTÿ)¢Æ«§ÿPJ8õ@êwôô©÷Ç*§ÍOÊ5]>ªt÷£•T\n§å!\" 6Y	)€ÈH¨/Pªž…3É	éð†/‘P~ àù	ªÓ®¨!\"ŸC’ÌÔýj¡ ¨eNJ¡üˆêˆñÔ*%Ô4¦1Q¡ÅCZ‡Q‘jTBQ.¢\rE)\0004Ëê\$€2¨SM+å<j„t¿j0Ô,¦9Q†¡}F\0\$±s©žTa¨KÎ£]Ecj*€'K»M¾—MGx½ÕRÇT1¦#Qê¡¥GªŠ5ª:Ôz¨Lš¡4u6z•\"j\"TˆKuNÖ£ýGÚg\$jFSÜ¨ïQ2¤¥Høîµ\"êMTƒ©%R¤•HzŽÕ\$ª,Ôw¨Re.\$rªzµ)©ÛÔ¦©-Qö ÍJ„¹‘Êª@Ô°©=R&/IÊ•1†*]T³‹À7¼˜¾QÒåD&Ó©qN¦_(´q²c[TwŒQRôå´œJš\0nâ÷T­¨û.¦˜956cÔÜŒÕSz¥H˜Á•7ªRÔ}ŽSr8¥NŠšÕ\"bÖTè§ÁQÞ5MNŠ–õ#ãçÔè©ESÂ§-H˜Á7\"ÜTü©_Sê§}GØÌ•?*yÔ©‹‡Sò§½P*Ÿ5#âöÔÜÏT:§]PÊŸõC*€Ô‰‹T:¨-K8Æ5Cª„ÕªR¦--MÈ¾•HªˆÕ ª'T‚¨­HøËõHªŒÔÑ‹×TŠ¨íRª£õ,âéÔÜ‹GTÚ©-SJ¤õM*”Ô©‹UTÚ©mMH¸õMª˜Õ>ªgSD³5MÈÂ•RªœÕHªwU\"©íK8ÕÕRª ÔÚŒ¡U*ª-U*¨ànÂ¾TÙIR­,t¢Z«ÕêY¶IUF«51ª¬µW)vÕk‹_KÆ«pJ«5Zj­Å¯©R4r\n¬^jIÓCKº„‚ª}UÊ“_ª°Ô›ªãO¬=N·R*¯F-ª½Rž¬%Wš‹Õcê¦Õ\\ŽaV>«EYj–µdªªÔÃ«UÎ¬µWXÍ5*ÈÕ‹’¹Uy‚õZŠ°1kã™Õ¨«7Vš¬R\\HÍ5h*ÖU¢©ÏUÆ§M[Š²±kêvÕ¸«3Vò­}[(ä5WªzÕ¸«iB­Oº®1¯ê¯Tý«—V®;­[øîµpRæGu«;T@0>\0‚ê/I³ªÿW`í]¦ô\0ªîÆ8«¿PŠ¯]ÈÍ1m*ïÕÇyUz¨mW¡õ|ªÝ“[«¡Ö¯…]J¬ÑˆêøU±««ö¯…Z*¤5\\j‘Ö«ëZªô`ZÁ5~ª®Eì¬Wú«4ZšÁ5h£QÕ^‹cXZ®•Sú®1o«Vª¹U&«TºÄ5}cU^›Xš°dm*³±’kUu¥«SfG=[¹õjäsÕ¿‘ÏX¦Kc\n®iRâHç«i#ž±uWt»µª½¥º«»XÂÕcÄ¹•«U†¬”rÚ¢õUZ‹Õ‡ƒNE¢¬‘Xº¬…4ÚÈudê·Eä¬eV^²íKÉànâòV8‹sXÂ¥ÍfÇõ/ÂhJ³-J]Ó‚…™ÓÎÁÕzO›±<Eh‰\$å‹“·¡ó\0Kœë<bw„ñ…>·”øNž\")]b£	â+zê.cS.¢iFç	ã£µQNQ«éV*ªéÛÎúÞO[X¤nxŠ¤P	k­§oNø£}<aOò§Iß“Áh·ºšT;òrñ‰‰¤ƒVD6Qß;zŠ]j×~'’:ë–[Ivôó7^Ê‘§ÖÁžjëºw[«ùæîºçœÊÅ†¥:u ÅDs#¦¿Î\\wµ<n|*á‰hëmÎKv;YÒˆ±Ú3á]Œ«^#—Zªj¥gy³jÄ§Y,”%;3¾³ÊÚù×.ÈW\"‘Ã\$Ù3>gÚœºÏÓÏ¦ªVTóZj¥hYÝjžkD*!šh&XzËiª•¥+GV—­\"¥æ¸Z:Ò¤§+‡NoG¥Zjj¥iÉ]ÊžkOÐ_­Ö¬ÔmjIª•¨§t¯–#½[âj\rnŠãê©×Ðn™ßZ¥_,Õé†ógÎÄš©:¹¼Å9‰Áÿ«[L2®W=TÔ×0®ãf¶\0P®U6\ns%7isYæ?£¿uá3¾’½nb5¡«Ÿ»šX|G~l•&×k¤¥·M§ †¯ú¶ŒÏy¡S–É)Î]œÜ­r·¶Ù¸µ¸æìÖê›Å?Õ}u'n0W-Î¹®æb·´ÇªìõŸk?»vQý7…Ü}p\nìõÀ’ÍÙ®Z*»9)Êá5Þ•ZW­-ZB¸²Œ:ìõã«ŠW\0WZfp•GpõîÍÙ®:Fpú¤ŠäUÙëSN/™Ï\\©Ü%s9¬S{§ ×8®ÏZÍasÊÛ“’+¢N^®“9™MÕ{…P5Óç ×Q®ÔîJº¢«y§õÕè;œÚîz¸ƒÂÕYÚV Ä3—:ïœDÅIŠÃ+ç‡ý¯£19M;º¥Œ’ô¨“V´®š\rQ{êÉÕ®•¶Å+£ƒFCLÄ¹ŠN¥–©Ôˆ\\ùÞ)\$iŒŽÛN'\0¦°PŠÂšõÊÇ]XÌ^s1òf&Š\"'<OøóšÌ¡ËL\0¹\"‡@Ö”¥%ä6úÂUAõ1ýi(zÌèÝ€\rÒÕ‚ä±ÈbZÀ”+IQOï3€ºË\r=*Ä‰ ‰)ñ¨!Áž Ð`ª¼h°ˆ,Ð«mGPCËA Ù²íƒA„Œ(ZÅ°%ƒtì,h/Á‰ˆi–Èk¬«¡XEJ6ð±„IDèÈ¬\"›\nïaU- ›«\nvŽy°_€ÄÂÂ›Ú«¯k	a½B<ÇVÂƒÛD»/P»ôaîÁ)9Lã¶(Z‚°8êvvÃ¹Øk	§oÐZXkäÑå§|´&°.Âæ±C¹’Øá°`€1€]7&Ä™+™H¤CBcX“B7xXó|1“€0¦ãaš6š°ubpJLÇ…–(·š÷mbl8I¶*Rö—@tk0€—¡¯ÅxXÛÁÓ;ÁÅ al]4s°t¿íÅªð0§c‡'´ælß`8MŒ8‘ÀÃ€D4w`p?@706gÌˆ~K±\r‚Û “P´…Ùbh€\"&¯\nìq‘PDÈÐÎó\$Ð(Í0QP<÷°àÀã¬Q!X´…xúÔ5€ˆR·`w/2°2#ŠÀ¸Ž `¬»‘1†/ˆÜ\r¡Ö:Â²–±¢£B7öV7ZŒ›gMYúH3È „ÙbÎ	ZÁÓJÅöGâwÙgl^Æ-‘R-!Íl“7Ì²Lõ†Æ°<1 íQC/Õ²h¼à)ÏWž6C	÷*dˆþ6]VK!mì…ØÜã€05G\$–R˜µ4¯±=Cw&[æ«YP²›dÉš³')VK,¨5eÈ\rÞÊè†K+ï1„X)bÛe)ÄâuF2A#EÑ&g~‘e¡y’fp5¨lYl²Ôœ5õƒö¿Ö\nÂŠÙm}`‚(¬M Pl9Yÿfø±ýÖ]€Vl-4ŽÃ©¦«ÂÁ>`À•/û³fPE™i‹\0k™vÆ\0ßfhS0±&ÍÂ¦lÍ¼¢#fuåÌû5	i%ÿ:Fd€ö9Ž™Ø€G<ä	{ö}ìÂs[7\0á¬Îž3íft:+.È”–p >ØÕ±£@!Pas6q,À³—1bÇ¬Å‹ãZK°ê±Ü-ú“ar`•?RxXÁé‘¡ÏVïú˜#Ä¤ÔzÂ; ÀD€•¾H²Á1¥’6D`žþYê`÷RÅPÖ‹>-Æ!\$Ùù³ì×~Ï€ÐÅà`>Ùï³õhÔ0ô1†À¬–&\0Ãh—ëûI–wlûZ„\$“\\\r¡8¶~,\nºo_áÀB2D´–ƒa1ê³àÇ©=¢v<ÏkF´p``”kBF¶6 ÄÖ²—hÆÉT TÖŽ	‡@?drÑå‰€JÀH@1°G´dnÁÒw‡Æ%äÚJGšÒ0bðTf]m(Øk´qg\\í½ó¸–¬ë°ê ÈÑˆ3vk'ý^d´¨AXÿ™~ÇW™VsÂ*¼Ê±æd´ûM À¬@?²ÄÓ}§6\\–m9<Î±i”Ý§›ˆÔ¬h½^s}æ-¦[Kœs±qãbÎÓ-“öOORm8\$ÞywÄì##°Œ@â·\0ôÒØ¤ 5F7ö¨ƒ X\nÓÀ|JË/-S™W!fÇ† 0¶,w½¨D4Ù¡RU¥T´ž’îÕðZXÇ=í`‰W\$@âÔ¥(‹XG§‹ÒŠµ—a>Ö*ûY¶²ˆ\n³ü\nŒìš!«[mjœµŠ0,mu¬W@ FXúÚÎòðü=­ (¦ý­b¿ý<!\n\"”ª83Ã'¦‚(R™Ý\n>”ù@¨W¦r!L£HÅkÌ\rˆE\nWÆÞ\r¢‚'FHœ\$£‹ääÀm„È=ÔÛ¥{LY—…&ÑÜ£_\0ŽÆüÝ#¢ä”€[„9\0¤\"ÔÒ@8ÄiKª¹ö0Ùl‰ÑÐp\ngî‚Û'qbF–Øyá«cl@9Û(#JU«Ý²ƒ{io­‘¥.{ÔÍ³4ÞVÍŠVnFÉxðÑüzÎ QàÞž\$kSa~Ê¨0s@£À«%…y@•À5HŽ†NÎÍ¦´@†x’#	Ü« /\\¥Ö?<hÚ‚ù…¼ITŒ :3Ã\n%—¸");}else{header("Content-Type: image/gif");switch($_GET["file"]){case"plus.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0!„©ËíMñÌ*)¾oú¯) q•¡eˆµî#ÄòLË\0;";break;case"cross.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0#„©Ëí#\naÖFo~yÃ._wa”á1ç±JîGÂL×6]\0\0;";break;case"up.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMQN\nï}ôža8ŠyšaÅ¶®\0Çò\0;";break;case"down.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMñÌ*)¾[Wþ\\¢ÇL&ÙœÆ¶•\0Çò\0;";break;case"arrow.gif":echo"GIF89a\0\n\0€\0\0€€€ÿÿÿ!ù\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹ž”ªÓ²Þ»\0\0;";break;}}exit;}function
connection(){global$g;return$g;}function
adminer(){global$b;return$b;}function
version(){global$ia;return$ia;}function
idf_unescape($v){$je=substr($v,-1);return
str_replace($je.$je,$je,substr($v,1,-1));}function
escape_string($X){return
substr(q($X),1,-1);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes($jg,$Vc=false){if(get_magic_quotes_gpc()){while(list($z,$X)=each($jg)){foreach($X
as$Yd=>$W){unset($jg[$z][$Yd]);if(is_array($W)){$jg[$z][stripslashes($Yd)]=$W;$jg[]=&$jg[$z][stripslashes($Yd)];}else$jg[$z][stripslashes($Yd)]=($Vc?$W:stripslashes($W));}}}}function
bracket_escape($v,$Oa=false){static$ji=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($v,($Oa?array_flip($ji):$ji));}function
min_version($Pi,$ye="",$h=null){global$g;if(!$h)$h=$g;$eh=$h->server_info;if($ye&&preg_match('~([\d.]+)-MariaDB~',$eh,$B)){$eh=$B[1];$Pi=$ye;}return(version_compare($eh,$Pi)>=0);}function
charset($g){return(min_version("5.5.3",0,$g)?"utf8mb4":"utf8");}function
script($nh,$ii="\n"){return"<script".nonce().">$nh</script>$ii";}function
script_src($Di){return"<script src='".h($Di)."'".nonce()."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($Q){return
str_replace("\0","&#0;",htmlspecialchars($Q,ENT_QUOTES,'utf-8'));}function
nbsp($Q){return(trim($Q)!=""?h($Q):"&nbsp;");}function
nl_br($Q){return
str_replace("\n","<br>",$Q);}function
checkbox($C,$Y,$fb,$fe="",$mf="",$kb="",$ge=""){$I="<input type='checkbox' name='$C' value='".h($Y)."'".($fb?" checked":"").($ge?" aria-labelledby='$ge'":"").">".($mf?script("qsl('input').onclick = function () { $mf };",""):"");return($fe!=""||$kb?"<label".($kb?" class='$kb'":"").">$I".h($fe)."</label>":$I);}function
optionlist($sf,$Yg=null,$Hi=false){$I="";foreach($sf
as$Yd=>$W){$tf=array($Yd=>$W);if(is_array($W)){$I.='<optgroup label="'.h($Yd).'">';$tf=$W;}foreach($tf
as$z=>$X)$I.='<option'.($Hi||is_string($z)?' value="'.h($z).'"':'').(($Hi||is_string($z)?(string)$z:$X)===$Yg?' selected':'').'>'.h($X);if(is_array($W))$I.='</optgroup>';}return$I;}function
html_select($C,$sf,$Y="",$lf=true,$ge=""){if($lf)return"<select name='".h($C)."'".($ge?" aria-labelledby='$ge'":"").">".optionlist($sf,$Y)."</select>".(is_string($lf)?script("qsl('select').onchange = function () { $lf };",""):"");$I="";foreach($sf
as$z=>$X)$I.="<label><input type='radio' name='".h($C)."' value='".h($z)."'".($z==$Y?" checked":"").">".h($X)."</label>";return$I;}function
select_input($Ka,$sf,$Y="",$lf="",$Vf=""){$Nh=($sf?"select":"input");return"<$Nh$Ka".($sf?"><option value=''>$Vf".optionlist($sf,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$Vf'>").($lf?script("qsl('$Nh').onchange = $lf;",""):"");}function
confirm($He="",$Zg="qsl('input')"){return
script("$Zg.onclick = function () { return confirm('".($He?js_escape($He):lang(0))."'); };","");}function
print_fieldset($u,$oe,$Si=false){echo"<fieldset><legend>","<a href='#fieldset-$u'>$oe</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$u');",""),"</legend>","<div id='fieldset-$u'".($Si?"":" class='hidden'").">\n";}function
bold($Wa,$kb=""){return($Wa?" class='active $kb'":($kb?" class='$kb'":""));}function
odd($I=' class="odd"'){static$t=0;if(!$I)$t=-1;return($t++%2?$I:'');}function
js_escape($Q){return
addcslashes($Q,"\r\n'\\/");}function
json_row($z,$X=null){static$Wc=true;if($Wc)echo"{";if($z!=""){echo($Wc?"":",")."\n\t\"".addcslashes($z,"\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X,"\r\n\"\\/").'"':'null');$Wc=false;}else{echo"\n}\n";$Wc=true;}}function
ini_bool($Ld){$X=ini_get($Ld);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
sid(){static$I;if($I===null)$I=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$I;}function
set_password($Oi,$N,$V,$F){$_SESSION["pwds"][$Oi][$N][$V]=($_COOKIE["adminer_key"]&&is_string($F)?array(encrypt_string($F,$_COOKIE["adminer_key"])):$F);}function
get_password(){$I=get_session("pwds");if(is_array($I))$I=($_COOKIE["adminer_key"]?decrypt_string($I[0],$_COOKIE["adminer_key"]):false);return$I;}function
q($Q){global$g;return$g->quote($Q);}function
get_vals($G,$d=0){global$g;$I=array();$H=$g->query($G);if(is_object($H)){while($J=$H->fetch_row())$I[]=$J[$d];}return$I;}function
get_key_vals($G,$h=null,$Wh=0,$hh=true){global$g;if(!is_object($h))$h=$g;$I=array();$h->timeout=$Wh;$H=$h->query($G);$h->timeout=0;if(is_object($H)){while($J=$H->fetch_row()){if($hh)$I[$J[0]]=$J[1];else$I[]=$J[0];}}return$I;}function
get_rows($G,$h=null,$o="<p class='error'>"){global$g;$yb=(is_object($h)?$h:$g);$I=array();$H=$yb->query($G);if(is_object($H)){while($J=$H->fetch_assoc())$I[]=$J;}elseif(!$H&&!is_object($h)&&$o&&defined("PAGE_HEADER"))echo$o.error()."\n";return$I;}function
unique_array($J,$x){foreach($x
as$w){if(preg_match("~PRIMARY|UNIQUE~",$w["type"])){$I=array();foreach($w["columns"]as$z){if(!isset($J[$z]))continue
2;$I[$z]=$J[$z];}return$I;}}}function
escape_key($z){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$z,$B))return$B[1].idf_escape(idf_unescape($B[2])).$B[3];return
idf_escape($z);}function
where($Z,$q=array()){global$g,$y;$I=array();foreach((array)$Z["where"]as$z=>$X){$z=bracket_escape($z,1);$d=escape_key($z);$I[]=$d.($y=="sql"&&preg_match('~^[0-9]*\\.[0-9]*$~',$X)?" LIKE ".q(addcslashes($X,"%_\\")):($y=="mssql"?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($q[$z],q($X))));if($y=="sql"&&preg_match('~char|text~',$q[$z]["type"])&&preg_match("~[^ -@]~",$X))$I[]="$d = ".q($X)." COLLATE ".charset($g)."_bin";}foreach((array)$Z["null"]as$z)$I[]=escape_key($z)." IS NULL";return
implode(" AND ",$I);}function
where_check($X,$q=array()){parse_str($X,$db);remove_slashes(array(&$db));return
where($db,$q);}function
where_link($t,$d,$Y,$of="="){return"&where%5B$t%5D%5Bcol%5D=".urlencode($d)."&where%5B$t%5D%5Bop%5D=".urlencode(($Y!==null?$of:"IS NULL"))."&where%5B$t%5D%5Bval%5D=".urlencode($Y);}function
convert_fields($e,$q,$L=array()){$I="";foreach($e
as$z=>$X){if($L&&!in_array(idf_escape($z),$L))continue;$Ha=convert_field($q[$z]);if($Ha)$I.=", $Ha AS ".idf_escape($z);}return$I;}function
cookie($C,$Y,$re=2592000){global$ba;return
header("Set-Cookie: $C=".urlencode($Y).($re?"; expires=".gmdate("D, d M Y H:i:s",time()+$re)." GMT":"")."; path=".preg_replace('~\\?.*~','',$_SERVER["REQUEST_URI"]).($ba?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
restart_session(){if(!ini_bool("session.use_cookies"))session_start();}function
stop_session(){if(!ini_bool("session.use_cookies"))session_write_close();}function&get_session($z){return$_SESSION[$z][DRIVER][SERVER][$_GET["username"]];}function
set_session($z,$X){$_SESSION[$z][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($Oi,$N,$V,$m=null){global$ec;preg_match('~([^?]*)\\??(.*)~',remove_from_uri(implode("|",array_keys($ec))."|username|".($m!==null?"db|":"").session_name()),$B);return"$B[1]?".(sid()?SID."&":"").($Oi!="server"||$N!=""?urlencode($Oi)."=".urlencode($N)."&":"")."username=".urlencode($V).($m!=""?"&db=".urlencode($m):"").($B[2]?"&$B[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
redirect($te,$He=null){if($He!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($te!==null?$te:$_SERVER["REQUEST_URI"]))][]=$He;}if($te!==null){if($te=="")$te=".";header("Location: $te");exit;}}function
query_redirect($G,$te,$He,$vg=true,$Cc=true,$Nc=false,$Vh=""){global$g,$o,$b;if($Cc){$vh=microtime(true);$Nc=!$g->query($G);$Vh=format_time($vh);}$qh="";if($G)$qh=$b->messageQuery($G,$Vh,$Nc);if($Nc){$o=error().$qh.script("messagesPrint();");return
false;}if($vg)redirect($te,$He.$qh);return
true;}function
queries($G){global$g;static$og=array();static$vh;if(!$vh)$vh=microtime(true);if($G===null)return
array(implode("\n",$og),format_time($vh));$og[]=(preg_match('~;$~',$G)?"DELIMITER ;;\n$G;\nDELIMITER ":$G).";";return$g->query($G);}function
apply_queries($G,$T,$zc='table'){foreach($T
as$R){if(!queries("$G ".$zc($R)))return
false;}return
true;}function
queries_redirect($te,$He,$vg){list($og,$Vh)=queries(null);return
query_redirect($og,$te,$He,$vg,false,!$vg,$Vh);}function
format_time($vh){return
lang(1,max(0,microtime(true)-$vh));}function
remove_from_uri($Gf=""){return
substr(preg_replace("~(?<=[?&])($Gf".(SID?"":"|".session_name()).")=[^&]*&~",'',"$_SERVER[REQUEST_URI]&"),0,-1);}function
pagination($E,$Jb){return" ".($E==$Jb?$E+1:'<a href="'.h(remove_from_uri("page").($E?"&page=$E".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($E+1)."</a>");}function
get_file($z,$Rb=false){$Tc=$_FILES[$z];if(!$Tc)return
null;foreach($Tc
as$z=>$X)$Tc[$z]=(array)$X;$I='';foreach($Tc["error"]as$z=>$o){if($o)return$o;$C=$Tc["name"][$z];$di=$Tc["tmp_name"][$z];$_b=file_get_contents($Rb&&preg_match('~\\.gz$~',$C)?"compress.zlib://$di":$di);if($Rb){$vh=substr($_b,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$vh,$Ag))$_b=iconv("utf-16","utf-8",$_b);elseif($vh=="\xEF\xBB\xBF")$_b=substr($_b,3);$I.=$_b."\n\n";}else$I.=$_b;}return$I;}function
upload_error($o){$Ee=($o==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($o?lang(2).($Ee?" ".lang(3,$Ee):""):lang(4));}function
repeat_pattern($Tf,$pe){return
str_repeat("$Tf{0,65535}",$pe/65535)."$Tf{0,".($pe%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\\0-\\x8\\xB\\xC\\xE-\\x1F]~',$X));}function
shorten_utf8($Q,$pe=80,$Bh=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$pe).")($)?)u",$Q,$B))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$pe).")($)?)",$Q,$B);return
h($B[1]).$Bh.(isset($B[2])?"":"<i>...</i>");}function
format_number($X){return
strtr(number_format($X,0,".",lang(5)),preg_split('~~u',lang(6),-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~[^a-z0-9_]~i','-',$X);}function
hidden_fields($jg,$Bd=array()){$I=false;while(list($z,$X)=each($jg)){if(!in_array($z,$Bd)){if(is_array($X)){foreach($X
as$Yd=>$W)$jg[$z."[$Yd]"]=$W;}else{$I=true;echo'<input type="hidden" name="'.h($z).'" value="'.h($X).'">';}}}return$I;}function
hidden_fields_get(){echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';}function
table_status1($R,$Oc=false){$I=table_status($R,$Oc);return($I?$I:array("Name"=>$R));}function
column_foreign_keys($R){global$b;$I=array();foreach($b->foreignKeys($R)as$r){foreach($r["source"]as$X)$I[$X][]=$r;}return$I;}function
enum_input($U,$Ka,$p,$Y,$tc=null){global$b;preg_match_all("~'((?:[^']|'')*)'~",$p["length"],$_e);$I=($tc!==null?"<label><input type='$U'$Ka value='$tc'".((is_array($Y)?in_array($tc,$Y):$Y===0)?" checked":"")."><i>".lang(7)."</i></label>":"");foreach($_e[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$fb=(is_int($Y)?$Y==$t+1:(is_array($Y)?in_array($t+1,$Y):$Y===$X));$I.=" <label><input type='$U'$Ka value='".($t+1)."'".($fb?' checked':'').'>'.h($b->editVal($X,$p)).'</label>';}return$I;}function
input($p,$Y,$s){global$ui,$b,$y;$C=h(bracket_escape($p["field"]));echo"<td class='function'>";if(is_array($Y)&&!$s){$Fa=array($Y);if(version_compare(PHP_VERSION,5.4)>=0)$Fa[]=JSON_PRETTY_PRINT;$Y=call_user_func_array('json_encode',$Fa);$s="json";}$Eg=($y=="mssql"&&$p["auto_increment"]);if($Eg&&!$_POST["save"])$s=null;$jd=(isset($_GET["select"])||$Eg?array("orig"=>lang(8)):array())+$b->editFunctions($p);$Ka=" name='fields[$C]'";if($p["type"]=="enum")echo
nbsp($jd[""])."<td>".$b->editInput($_GET["edit"],$p,$Ka,$Y);else{$sd=(in_array($s,$jd)||isset($jd[$s]));echo(count($jd)>1?"<select name='function[$C]'>".optionlist($jd,$s===null||$sd?$s:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):nbsp(reset($jd))).'<td>';$Nd=$b->editInput($_GET["edit"],$p,$Ka,$Y);if($Nd!="")echo$Nd;elseif(preg_match('~bool~',$p["type"]))echo"<input type='hidden'$Ka value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$Ka value='1'>";elseif($p["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$p["length"],$_e);foreach($_e[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$fb=(is_int($Y)?($Y>>$t)&1:in_array($X,explode(",",$Y),true));echo" <label><input type='checkbox' name='fields[$C][$t]' value='".(1<<$t)."'".($fb?' checked':'').">".h($b->editVal($X,$p)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$p["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$C'>";elseif(($Th=preg_match('~text|lob~',$p["type"]))||preg_match("~\n~",$Y)){if($Th&&$y!="sqlite")$Ka.=" cols='50' rows='12'";else{$K=min(12,substr_count($Y,"\n")+1);$Ka.=" cols='30' rows='$K'".($K==1?" style='height: 1.2em;'":"");}echo"<textarea$Ka>".h($Y).'</textarea>';}elseif($s=="json"||preg_match('~^jsonb?$~',$p["type"]))echo"<textarea$Ka cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';else{$Ge=(!preg_match('~int~',$p["type"])&&preg_match('~^(\\d+)(,(\\d+))?$~',$p["length"],$B)?((preg_match("~binary~",$p["type"])?2:1)*$B[1]+($B[3]?1:0)+($B[2]&&!$p["unsigned"]?1:0)):($ui[$p["type"]]?$ui[$p["type"]]+($p["unsigned"]?0:1):0));if($y=='sql'&&min_version(5.6)&&preg_match('~time~',$p["type"]))$Ge+=7;echo"<input".((!$sd||$s==="")&&preg_match('~(?<!o)int(?!er)~',$p["type"])&&!preg_match('~\[\]~',$p["full_type"])?" type='number'":"")." value='".h($Y)."'".($Ge?" data-maxlength='$Ge'":"").(preg_match('~char|binary~',$p["type"])&&$Ge>20?" size='40'":"")."$Ka>";}echo$b->editHint($_GET["edit"],$p,$Y);$Wc=0;foreach($jd
as$z=>$X){if($z===""||!$X)break;$Wc++;}if($Wc)echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $Wc), oninput: function () { this.onchange(); }});");}}function
process_input($p){global$b,$n;$v=bracket_escape($p["field"]);$s=$_POST["function"][$v];$Y=$_POST["fields"][$v];if($p["type"]=="enum"){if($Y==-1)return
false;if($Y=="")return"NULL";return+$Y;}if($p["auto_increment"]&&$Y=="")return
null;if($s=="orig")return($p["on_update"]=="CURRENT_TIMESTAMP"?idf_escape($p["field"]):false);if($s=="NULL")return"NULL";if($p["type"]=="set")return
array_sum((array)$Y);if($s=="json"){$s="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$p["type"])&&ini_bool("file_uploads")){$Tc=get_file("fields-$v");if(!is_string($Tc))return
false;return$n->quoteBinary($Tc);}return$b->processInput($p,$Y,$s);}function
fields_from_edit(){global$n;$I=array();foreach((array)$_POST["field_keys"]as$z=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$z];$_POST["fields"][$X]=$_POST["field_vals"][$z];}}foreach((array)$_POST["fields"]as$z=>$X){$C=bracket_escape($z,1);$I[$C]=array("field"=>$C,"privileges"=>array("insert"=>1,"update"=>1),"null"=>1,"auto_increment"=>($z==$n->primary),);}return$I;}function
search_tables(){global$b,$g;$_GET["where"][0]["val"]=$_POST["query"];$bh="<ul>\n";foreach(table_status('',true)as$R=>$S){$C=$b->tableName($S);if(isset($S["Engine"])&&$C!=""&&(!$_POST["tables"]||in_array($R,$_POST["tables"]))){$H=$g->query("SELECT".limit("1 FROM ".table($R)," WHERE ".implode(" AND ",$b->selectSearchProcess(fields($R),array())),1));if(!$H||$H->fetch_row()){$fg="<a href='".h(ME."select=".urlencode($R)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$C</a>";echo"$bh<li>".($H?$fg:"<p class='error'>$fg: ".error())."\n";$bh="";}}}echo($bh?"<p class='message'>".lang(9):"</ul>")."\n";}function
dump_headers($_d,$Qe=false){global$b;$I=$b->dumpHeaders($_d,$Qe);$Ef=$_POST["output"];if($Ef!="text")header("Content-Disposition: attachment; filename=".$b->dumpFilename($_d).".$I".($Ef!="file"&&!preg_match('~[^0-9a-z]~',$Ef)?".$Ef":""));session_write_close();ob_flush();flush();return$I;}function
dump_csv($J){foreach($J
as$z=>$X){if(preg_match("~[\"\n,;\t]~",$X)||$X==="")$J[$z]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")),$J)."\r\n";}function
apply_sql_function($s,$d){return($s?($s=="unixepoch"?"DATETIME($d, '$s')":($s=="count distinct"?"COUNT(DISTINCT ":strtoupper("$s("))."$d)"):$d);}function
get_temp_dir(){$I=ini_get("upload_tmp_dir");if(!$I){if(function_exists('sys_get_temp_dir'))$I=sys_get_temp_dir();else{$Uc=@tempnam("","");if(!$Uc)return
false;$I=dirname($Uc);unlink($Uc);}}return$I;}function
file_open_lock($Uc){$hd=@fopen($Uc,"r+");if(!$hd){$hd=@fopen($Uc,"w");if(!$hd)return;chmod($Uc,0660);}flock($hd,LOCK_EX);return$hd;}function
file_write_unlock($hd,$Lb){rewind($hd);fwrite($hd,$Lb);ftruncate($hd,strlen($Lb));flock($hd,LOCK_UN);fclose($hd);}function
password_file($i){$Uc=get_temp_dir()."/adminer.key";$I=@file_get_contents($Uc);if($I||!$i)return$I;$hd=@fopen($Uc,"w");if($hd){chmod($Uc,0660);$I=rand_string();fwrite($hd,$I);fclose($hd);}return$I;}function
rand_string(){return
md5(uniqid(mt_rand(),true));}function
select_value($X,$A,$p,$Uh){global$b;if(is_array($X)){$I="";foreach($X
as$Yd=>$W)$I.="<tr>".($X!=array_values($X)?"<th>".h($Yd):"")."<td>".select_value($W,$A,$p,$Uh);return"<table cellspacing='0'>$I</table>";}if(!$A)$A=$b->selectLink($X,$p);if($A===null){if(is_mail($X))$A="mailto:$X";if(is_url($X))$A=$X;}$I=$b->editVal($X,$p);if($I!==null){if($I==="")$I="&nbsp;";elseif(!is_utf8($I))$I="\0";elseif($Uh!=""&&is_shortable($p))$I=shorten_utf8($I,max(0,+$Uh));else$I=h($I);}return$b->selectVal($I,$A,$p,$X);}function
is_mail($qc){$Ia='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$dc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$Tf="$Ia+(\\.$Ia+)*@($dc?\\.)+$dc";return
is_string($qc)&&preg_match("(^$Tf(,\\s*$Tf)*\$)i",$qc);}function
is_url($Q){$dc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^(https?)://($dc?\\.)+$dc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$Q);}function
is_shortable($p){return
preg_match('~char|text|lob|geometry|point|linestring|polygon|string|bytea~',$p["type"]);}function
count_rows($R,$Z,$Td,$md){global$y;$G=" FROM ".table($R).($Z?" WHERE ".implode(" AND ",$Z):"");return($Td&&($y=="sql"||count($md)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$md).")$G":"SELECT COUNT(*)".($Td?" FROM (SELECT 1$G GROUP BY ".implode(", ",$md).") x":$G));}function
slow_query($G){global$b,$fi;$m=$b->database();$Wh=$b->queryTimeout();if(support("kill")&&is_object($h=connect())&&($m==""||$h->select_db($m))){$de=$h->result(connection_id());echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$de,'&token=',$fi,'\');
}, ',1000*$Wh,');
</script>
';}else$h=null;ob_flush();flush();$I=@get_key_vals($G,$h,$Wh,false);if($h){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$I;}function
get_token(){$rg=rand(1,1e6);return($rg^$_SESSION["token"]).":$rg";}function
verify_token(){list($fi,$rg)=explode(":",$_POST["token"]);return($rg^$_SESSION["token"])==$fi;}function
lzw_decompress($Sa){$Zb=256;$Ta=8;$mb=array();$Gg=0;$Hg=0;for($t=0;$t<strlen($Sa);$t++){$Gg=($Gg<<8)+ord($Sa[$t]);$Hg+=8;if($Hg>=$Ta){$Hg-=$Ta;$mb[]=$Gg>>$Hg;$Gg&=(1<<$Hg)-1;$Zb++;if($Zb>>$Ta)$Ta++;}}$Yb=range("\0","\xFF");$I="";foreach($mb
as$t=>$lb){$pc=$Yb[$lb];if(!isset($pc))$pc=$dj.$dj[0];$I.=$pc;if($t)$Yb[]=$dj.$pc[0];$dj=$pc;}return$I;}function
on_help($tb,$ih=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $tb, $ih) }, onmouseout: helpMouseout});","");}function
edit_form($a,$q,$J,$Bi){global$b,$y,$fi,$o;$Gh=$b->tableName(table_status1($a,true));page_header(($Bi?lang(10):lang(11)),$o,array("select"=>array($a,$Gh)),$Gh);if($J===false)echo"<p class='error'>".lang(12)."\n";echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';if(!$q)echo"<p class='error'>".lang(13)."\n";else{echo"<table cellspacing='0'>".script("qsl('table').onkeydown = editingKeydown;");foreach($q
as$C=>$p){echo"<tr><th>".$b->fieldName($p);$Sb=$_GET["set"][bracket_escape($C)];if($Sb===null){$Sb=$p["default"];if($p["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$Sb,$Ag))$Sb=$Ag[1];}$Y=($J!==null?($J[$C]!=""&&$y=="sql"&&preg_match("~enum|set~",$p["type"])?(is_array($J[$C])?array_sum($J[$C]):+$J[$C]):$J[$C]):(!$Bi&&$p["auto_increment"]?"":(isset($_GET["select"])?false:$Sb)));if(!$_POST["save"]&&is_string($Y))$Y=$b->editVal($Y,$p);$s=($_POST["save"]?(string)$_POST["function"][$C]:($Bi&&$p["on_update"]=="CURRENT_TIMESTAMP"?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(preg_match("~time~",$p["type"])&&$Y=="CURRENT_TIMESTAMP"){$Y="";$s="now";}input($p,$Y,$s);echo"\n";}if(!support("table"))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",$b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($q){echo"<input type='submit' value='".lang(14)."'>\n";if(!isset($_GET["select"])){echo"<input type='submit' name='insert' value='".($Bi?lang(15):lang(16))."' title='Ctrl+Shift+Enter'>\n",($Bi?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".lang(17)."...', this); };"):"");}}echo($Bi?"<input type='submit' name='delete' value='".lang(18)."'>".confirm()."\n":($_POST||!$q?"":script("focus(qsa('td', qs('#form'))[1].firstChild);")));if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$fi,'">
</form>
';}global$b,$g,$ec,$mc,$wc,$o,$jd,$pd,$ba,$Md,$y,$ca,$ie,$kf,$Uf,$zh,$td,$fi,$li,$ui,$Ai,$ia;if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];$ba=$_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off");@ini_set("session.use_trans_sid",false);if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");$Hf=array(0,preg_replace('~\\?.*~','',$_SERVER["REQUEST_URI"]),"",$ba);if(version_compare(PHP_VERSION,'5.2.0')>=0)$Hf[]=true;call_user_func_array('session_set_cookie_params',$Hf);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$Vc);if(get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("zend.ze1_compatibility_mode",false);@ini_set("precision",15);$ie=array('en'=>'English','ar'=>'Ø§Ù„Ø¹Ø±Ø¨ÙŠØ©','bg'=>'Ð‘ÑŠÐ»Ð³Ð°Ñ€ÑÐºÐ¸','bn'=>'à¦¬à¦¾à¦‚à¦²à¦¾','bs'=>'Bosanski','ca'=>'CatalÃ ','cs'=>'ÄŒeÅ¡tina','da'=>'Dansk','de'=>'Deutsch','el'=>'Î•Î»Î»Î·Î½Î¹ÎºÎ¬','es'=>'EspaÃ±ol','et'=>'Eesti','fa'=>'ÙØ§Ø±Ø³ÛŒ','fi'=>'Suomi','fr'=>'FranÃ§ais','gl'=>'Galego','he'=>'×¢×‘×¨×™×ª','hu'=>'Magyar','id'=>'Bahasa Indonesia','it'=>'Italiano','ja'=>'æ—¥æœ¬èªž','ko'=>'í•œêµ­ì–´','lt'=>'LietuviÅ³','ms'=>'Bahasa Melayu','nl'=>'Nederlands','no'=>'Norsk','pl'=>'Polski','pt'=>'PortuguÃªs','pt-br'=>'PortuguÃªs (Brazil)','ro'=>'Limba RomÃ¢nÄƒ','ru'=>'Ð ÑƒÑÑÐºÐ¸Ð¹','sk'=>'SlovenÄina','sl'=>'Slovenski','sr'=>'Ð¡Ñ€Ð¿ÑÐºÐ¸','ta'=>'à®¤â€Œà®®à®¿à®´à¯','th'=>'à¸ à¸²à¸©à¸²à¹„à¸—à¸¢','tr'=>'TÃ¼rkÃ§e','uk'=>'Ð£ÐºÑ€Ð°Ñ—Ð½ÑÑŒÐºÐ°','vi'=>'Tiáº¿ng Viá»‡t','zh'=>'ç®€ä½“ä¸­æ–‡','zh-tw'=>'ç¹é«”ä¸­æ–‡',);function
get_lang(){global$ca;return$ca;}function
lang($v,$bf=null){if(is_string($v)){$Xf=array_search($v,get_translations("en"));if($Xf!==false)$v=$Xf;}global$ca,$li;$ki=($li[$v]?$li[$v]:$v);if(is_array($ki)){$Xf=($bf==1?0:($ca=='cs'||$ca=='sk'?($bf&&$bf<5?1:2):($ca=='fr'?(!$bf?0:1):($ca=='pl'?($bf%10>1&&$bf%10<5&&$bf/10%10!=1?1:2):($ca=='sl'?($bf%100==1?0:($bf%100==2?1:($bf%100==3||$bf%100==4?2:3))):($ca=='lt'?($bf%10==1&&$bf%100!=11?0:($bf%10>1&&$bf/10%10!=1?1:2)):($ca=='bs'||$ca=='ru'||$ca=='sr'||$ca=='uk'?($bf%10==1&&$bf%100!=11?0:($bf%10>1&&$bf%10<5&&$bf/10%10!=1?1:2)):1)))))));$ki=$ki[$Xf];}$Fa=func_get_args();array_shift($Fa);$ed=str_replace("%d","%s",$ki);if($ed!=$ki)$Fa[0]=format_number($bf);return
vsprintf($ed,$Fa);}function
switch_lang(){global$ca,$ie;echo"<form action='' method='post'>\n<div id='lang'>",lang(19).": ".html_select("lang",$ie,$ca,"this.form.submit();")," <input type='submit' value='".lang(20)."' class='hidden'>\n","<input type='hidden' name='token' value='".get_token()."'>\n";echo"</div>\n</form>\n";}if(isset($_POST["lang"])&&verify_token()){cookie("adminer_lang",$_POST["lang"]);$_SESSION["lang"]=$_POST["lang"];$_SESSION["translations"]=array();redirect(remove_from_uri());}$ca="en";if(isset($ie[$_COOKIE["adminer_lang"]])){cookie("adminer_lang",$_COOKIE["adminer_lang"]);$ca=$_COOKIE["adminer_lang"];}elseif(isset($ie[$_SESSION["lang"]]))$ca=$_SESSION["lang"];else{$va=array();preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~',str_replace("_","-",strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])),$_e,PREG_SET_ORDER);foreach($_e
as$B)$va[$B[1]]=(isset($B[3])?$B[3]:1);arsort($va);foreach($va
as$z=>$ng){if(isset($ie[$z])){$ca=$z;break;}$z=preg_replace('~-.*~','',$z);if(!isset($va[$z])&&isset($ie[$z])){$ca=$z;break;}}}$li=$_SESSION["translations"];if($_SESSION["translations_version"]!=3420885397){$li=array();$_SESSION["translations_version"]=3420885397;}function
get_translations($he){switch($he){case"en":$f="A9D“yÔ@s:ÀGà¡(¸ffƒ‚Š¦ã	ˆÙ:ÄS°Þa2\"1¦..L'ƒI´êm‘#Çs,†KƒšOP#IÌ@%9¥i4Èo2ÏÆó €Ë,9%ÀPÀb2£a¸àr\n2›NCÈ(Þr4™Í1C`(:Ebç9AÈi:‰&ã™”åy·ˆFó½ÐY‚ˆ\r´\n– 8ZÔS=\$Aœ†¤`Ñ=ËÜŒ²‚ž0Ê\nÒãdFé	ŒÞn:ZÎ°)­ãQ¦ÕÈmwÛø€ÝO¼êmfpQËÎ‚‰†qœêaÊÄ¯ ¢„\\Ã}ö5ð#|@èhÚ3·ÃN¾}@¡ÑiÕ¦¦t´sN}+ö\\òp¤Û¥æ+÷ÌˆÎ NbBØ­8„µŒ#’Ê'£ î³`PŽ2ð+à²‰‰ëÚÔ*ŠÂÔ/ÌhäúH¤\nê:ãœ9Ž+8Šºí8˜7­Cs¨¿\r®`ÊØôj‰Ð€ŒÁèD4ƒ à9‡Ax^;Êr@6­kð\\³Œá|w-<QØæòÁxD ÂJÄ‹À­€xŒ!ò~ŸBÃ@ß£C«°)Š0Ë:Ò8ã(Æ¦³k‹Q9è;à:ÏèKN Œèä2c(îQ”sB‹4ðe\n¼Câ¼78o˜JŒCË:ÔaJÎ¾bÞ6%ñ°¨û´õpÛ4¯\"êÌ/c\\8£(Ì0Ž´m 0Ö\r8§>ÏàPŒ:ÓüÀùˆ#8Î€ŒìäÁA#Ð9ƒÈîð -BÎ¼ŒŠHÇ®îk”–¶Â£Çc;¿JZM}b”ºp9ŒncQ<„\ruo,ÏÄl9´Ô¥úÐ1ƒ§J¾¸ÁB\0 öòÂ0ÅËˆÅã¸¾@(2L£ó38\"jÿŒãlíüÓâ9¦\"MF=Œ/¨½›FÄlB\r»ƒ0Ì6J©Df3 «È¨7£QÈÜ<£kåuŽc˜ÍbÇ±£v2ðREl­aÓTÊƒuvÑ:ž«pë(@Ç®kÛ}±ìºÃ 0í;ZC¶íì2ö;YJB!ŠbŒËã\\v[XË¼	\"Î˜oë^j(>¶¤ï#bP*1cpÖŸË;²á„É¶¯Û#\\ò]4|‚ÅH’2€Ê:(Ø¹³\\Û>k³Ö8\r(É²#£.I½Û?\0007%	T=GŽLV©þgÊwr…#IT™'J¼¥ÙÊ£”®9K2Û/LÉ–MØèñ“q@	Å9¹\\“j)§à95güòù¯tAÁ™Ò\\TUQ´\"Š`2:w2WËÕä™~ŸÃ _l\r&¤ˆ3)fìÞúýz€‚÷0@˜b`¯9ÿ•aŒ÷<‹è·›ð@wa¼‚°¬(€ zÏ/€€\0RHˆ	\"q˜Ñ…\\úÒ9°È†“&EÌ©!‚¤øÐ²š²	™5%ÄšØxl!ðl0Ä¨–â`ÛƒiüQñ\"8HVIN8d'Å=u“Xä«Ò;­_I\"zÑ „»’ÜA×c˜48›80Œ0vNÑGôvÁHñØ;æî™WNÕQi’<)…@@Ä\\ R&ª Ïd_Ô|”crÉÌÀ'nINpr[PH»¤cICF`§0Ì‘â@H¥Ègr¬›#&HÂ0T‰è	µ%Ï‰\$©”É2ÎKKÕrHtâe4Ñ°O	À€*…\0ˆB ET@Š-	c*½X›àÂ‰Â‚	¢è4ú¢dd½W¸O,kMJI<p	Ho5Dr”š¢ŽÑ´Â\r´¨ÓÇF˜HYÊ1%ý‘#|bÍQü•áÁÁHäˆ€EìéZ³YON›(\ríá¡ L>SÌ÷™ÄìC	ò\"Š@é7¹ƒC8h’:(?ˆ\$PR4\$‰&&ð0¥AI[êº›ô\r\\'JÕ\n‡ßRñE¡¢— Üâ)»%cïe\0‡NÉ\n‘RaX4© `ÅŽ]!àü±I’k\nyù\nd9.»>‚Lª¹aèÙiï>Aû³å¡kÚJ€íá•DaA#¤xÓUWv¼„g6g+»QJ§Ì\"˜Ó`‘{4zLÙ;å( Aa JRýgIóH7Å2%.zŽC‘ƒ´÷”Ù ¢HAx ¾æÂ*‚B`Ì(\n\n7Õ¬ZÆÛÉO	m‘TàX¬Lr8¿`[IìP ÁX2ÿ˜KÒÒ°Œ-Äiƒ5i°3o%\n¦ó6lS†pP.¿×Òó™l_\nñ‹/Âö¥B›€™D'ro\"Ü„@²!Ä÷¨»°È8Pç‘¼D@(+†PÅ”¬å®ÁIhBŠjÈpˆïT¿_%a3lÀ·Ä³Ÿ0†‹9egY—bðLKhI3¤ÀÅ“ê„õWIÈ¨ùè°˜£¯eyP:=À,û¢©»/Ö)Óš-\rŸƒ-C¨§ãZq£óù1QÕO-A¦^¬•@wKQâÀsRªÁXk¦Ù	Lqj*o!td¿—‡”©QF½¯Åó`›‡E‘=XY'Ì½Ú3-P¡YlÒž™ø¢jÀ6½PPEÎiß%º²%©´>¡¨¾£b*y¹ô¾0Hîîê–É5<¯ÕZSsTÍã´­G\nlý!nQ/ôßà›ÿƒï¾É¸d¯Úeú£„8átUÚUâ:¦8\\9(aÄ	ÿ	+¥·Ï&\\xŸáÓƒñö 6â}ñ¾»4ç2Ÿž}V±ÊuÄW;™óËsÏ¹·ÄV¬„®³rh_¢\r`´Sn§ìSv„I‡5<‘–CðÙ%tY‚å6MÂ×hóI.=D¦Ïåcz\\ºDâ‹F±ÕÏZç\\ÓŸZþØÍØË©:6×©íÄmg—6âoŽ«ÙÕÐ7^í%#ÇðmõS±»s›Ç2û­Ö<¶€á8Šê¿ïÀ}'Ÿé>`”ZbçîÓ¾Â®³0Šk<ö¡z¦Âœ‡”dJJ!4ü›ŒòCÍü—x›£Lq/PJ>'Ëõ~ozæ¾´vRÆF©Ì5Ëæ˜ç×„>Å›}ÅÖUwA¤%êõå”o7tæÞGœ¢ãÓºJOŸßæo/¨ï\\/¯øüˆpþfî‹>VæôgOOòõ´>¯Ý\0ƒìÛ@¨¸#êò·bÒ¸ONÚ‡Oï¨õ«fl°:»ÏÀfÃá\$F\n‚Z4ïJ6Inp¨àª7>èBQ02øïô@:ãÀE¯¢Ö ŽšPh˜@ìr#NU/ÌtŽl\rhHÂP 0fðÙãpÔ0¨åo2#Ã~¿fÒ#\"â- –„ÄÏoäm(Æe8\rªnäL ä2>\0Ø`Æi€Æ\rnÒ\$ml#ªN`ÒÆ°/Ò'Æƒ&Ôz ª\n€Œ p)Å£ƒšÅn\\æÂZ‰h:Æl€ÐÊ‚àñ6½ÌD\"m,3‚±.Ô4JR.ñý@Ø æ6¢óÂœ.âš¹ü3\ngÆ°–jÂYf%\n2:1b**â›êf‹&#%Ú8…ÆUâ \"Q«^«q@Ú.På¢Õm+²Ô*f1­YäßMØ³±Ê.q²ÞOèÔ‹­BÝ„°qÖ2ÉØ³J¸zKZ­Níkeía-Þ\0˜¤¾ÚÀñ ÒÜÀ@Âøl<ªè@¢^¡jFJ‚vR‚Ø26cÁ¯Ô{§š·e `#’	ªh€Â˜\\‰~Þã§%C¢`à,¥–ÿŠ¸cÏÐ\"å()¢ÔºÃ/+ö ZG\"LæÂú6dU2‰(ÈõN)\"¤";break;case"ar":$f="ÙC¶P‚Â²†l*„\r”,&\nÙA¶í„ø(J.™„0Se\\¶\r…ŒbÙ@¶0´,\nQ,l)ÅÀ¦Âµ°¬†Aòéj_1CÐM…«e€¢S™\ng@ŸOgë¨ô’XÙDMë)˜°0Œ†cA¨Øn8Çe*y#au4¡ ´Ir*;rSÁUµdJ	}‰ÎÑ*zªU@¦ŠX;ai1l(nóÕòýÃ[Óy™dÞu'c(€ÜoF“±¤Øe3™Nb¦ êp2NšS¡ Ó³:LZúz¶PØ\\bæ¼uÄ.•[¶Q`u	!Š­Jyµˆ&2¶(gTÍÔSÑšMÆxì5g5¸K®K¦Â¦àØ÷á—0Ê‡Æ¢¶§\nS ü›r\$ ®êjÄ(î¢v†°Ì¶!Jbž¸¡‰q««0\n¸šj\nÙˆé­¥jƒù@Åzšl<\$W¿ÈrØ“£åsœñ§Ì†U&…[Í*¯³lƒêŽ (B&÷¾ÆÉè4_!ÄÀËd\\B¾ñ=Èt[¢	ãë?‰:²X£ªØ¢eJ	\$£éÚ\n&Œ3Þœ:îšã•ÊÃ±?+T\n‰Ð¬§	JÓ\0x0´#Ê3¡Ð:ƒ€æáxïQ…ÃÈ6½C(ä\rãÎŒ£u`<7cpæ4õD¦ÂHÚ85ãmb:xÂ)m„Þã#hÛm(¦(‰ƒKv§¤%‰°[G’B«=2m[Ž£“j©Q%º±uqÛsìdÄÐJCD©SZªÉ»¬‰B¸Â9\rÏPÎŽ¶t #÷ö–«1¤±^OÚ|ëW‘e†/ÈJ]9J¨ð\"Rãê6\0ì0ƒ¨ÊûÀËÜò’F±r²¸ÞIÂZ—)¥Ö›kR<ñ‘Jº#=^VÖe\$O²°Y<Ð^\$[ßbZÆ¥-ým< P“£„×£cÂ7L)DœÚbbÔ‡©£Œíb®²…ä¤ÖêO\nö„î·vï2@¦ÁoÃ1lkÀÈ¦7[½¼/…­q–÷Aï·øê1…¿§Ü;N—®`uùwf†Ã½#¼+ûGN,†õ;[ÓÎ ‚üþqÜFáÆƒè6LóA´£xÌ3\r•K\nüQ<MÉ¸*\rí@Û³!\0ë[£ÆÙc6N\rƒxÎõach9{£Î0½Aë„„@Ü:·a@æ\nJy'!¢È0¦‚1*„|’”C¨+Arl!«i\0 ¥´{ËŠÝDlx†£tÖ›[Ú1z…Â“’Ÿ×¢Ý„hu;˜Òú[ ƒ×4A¸5›0Ì«^ò·=`€ ªuRŸpcW*Ü2* @¤Ôª—S%0àÈ®MÓX«§º²ö!ÈJÝ'É(\rUÄ3”[d¸ADbÓÐPH ¨ÅðLÂhafì9˜äÃº­YÁ”<\0Ò¥ƒ\$‰¡K)…4§ò TJ‘S?¥T«r°VQñZ«urÕØsWªý`¬8¦²\ncù«1gWòCY¥ZÆ¥U=°Ü°ÖÁu\"T”ŸµcRÒ‹E’fA¥!Œ:+€Ü¹®l!ˆÒ‡U\rÃ’ÂYÁ„3GB6ø_s|¯ô¾¹2Mé´˜\$l0¬ @äÃ\r,°9¡sø„L€¯ET’¡”:VØ“!ÈÍpšÐ ’?f†»HU§±Zb'Ô™„5s+æ#Yæ¤ÕšÓ^lVppU¡ÐÙ›óLÙK,}!Ü2È|·ÝºÝÊ:yÀÂ¿6\$Í±Ó\rÊÛ!GQ½O#¨AŠE(çÈå¥5g¡ZAª“ËXÀ²I˜I#AäÏ‚\0ÈVq§e+D7JS|lÔ°qeÑÌ`äÃl<‡Ò¾:›Õc9ßJÑœTx8? ËMkPÐv,…\0žÂ¡\"-õm;C\0LjBSLk¬½¥6.Q!6gT½PIúCÎ}ŠNí=Ï§Vðbh*Ér\r¹÷INàÈP	@ÎÕVÍ1Í»éTÀJ ÒÁm¬¦¸ÒšÕ(‚ P¶•uû+ú6ý™Mf­mUEV{N:*¢¶3¢ßR2ƒ\\ìxŠ€Âp \n¡@\"¨nýá&[Î˜a2ƒaóâø&40„tôF­QØZVgiÎP¶(¥Ú]¤T]ˆ:Rnõ3’á‰°QÁ‡à”¤V|“²@ø ¹šS~it¦41¦¦2l,	~\nfèÉnáæþ*»…\\íã\rYæùJ1{‰;æ@ña”ç†ák¶Ç8ùÚ8Öñã¡ø€¶¹²l îÉ.!½'iB­úŒ.’‘wrZ3G€‚Õ\\\"™‰cL(]ê•¸5ÖˆÉÎgwî¡ æ”º‰¥‡0F()†ôËèr¿Œ¼)†S_1)+r\$D¡È»ÑoKWí0(0Æ8ÇIÖósúÎ5¡”;“E²¼Wó6;Ül\nD€l)pš˜ÇêHéÝJ‹¸@¸é€p%¤¤Ì“[ªN.»\":A¿¡%ÄÖ°;À„bOhé^Byå=C +©E#çÓ(—'ªÌº5F\$Ù	4ùeOã›un/¦S™Óæ\n!„€AX•Pi6VÑKQú¶mèÓÂ¤´Ñ&”Êäˆ-£h¨9è¦Ö˜À/Y…#ÞáÓ„2¨œ”žña¸jú/1÷?‡-O”Ë7R'BƒLÌ™ycÈuŽfn›HY>.EïŽQa	S<Â¤ðÄÅAKaI\$„Bòj€OcÜ÷¢rÃçï&é‹úB^¨H€RÕU¦³‡r9—jr'Ú×´¨\$†¬½ž¤4Ç•A	^<*ž) ©!¹B†rÚ]1Ø—;»„	OE¾èi(d¦†ú‘:ŽÓr±VAè£9Bà€XPa\\u¸T¡¹m—QË‘=íÇTæ¸È¡á6''÷É}’Nyw®.Gí«ûlÐê;¤‹wÞ@ácíÐ^(CgQ{Ô~~›²õ._4Â{ý×\"Ó¯ú¨ø¯o´¾u!6]í)	ÈõæMŒd|ûJÏ@\n`?º\r1BÜWÅ×eÚÃ(‡ó:¸üæ<þ‹@üêO pO¤?X÷Ì+\$RÔã/hbü¨¿‚\$jÎÀêOdòòÈnÈEÂè²øBKÆöOÄ2ýˆÄÇìlsq¯¬qO°È‡fÅ°fB‘\0èSEPIêÑÏúçZpùåæ÷GxËnÆ\$\"pR2/~ƒiá\nãÄ:¾1!}ÎN[®Tã(1äÊÊLãL.º„È8í{\rÎRºÇk°ž‚£!OA„ñ	0m	oý(aü#ÂžÁ¢\$ÔÖ	ê@Md1 #âúÌï&<]#Ën˜8áfjÄP}Â«±.Œ#Nò †–pÔîº¦\"\\ÖlS;pNÔˆ(_P]d<l¶/qQÐ(CÄêï×ÂæØjF¯©-Üó­hÖÅ×\r”okæ¡aO	ÏsàÏo\r¯ˆ-±Á¬wB‚ÓñÊuQq‘¾ÍÄäpí¯¤jA±‘Ìu‘ÜÄb'OZpmÉ,u» lêkEÖ\"o5„N‹ºM%ònc Šå‚ŠÏ:k°<Ño–©‚¶Ü\r¯¢[°¾:òGmÙ\$ÒCŸÊTòq©Æ´/§H2R Å&Rs%o&ÌxÂø‰ð]‚öÄÒ<[¤HÂÓÏ©y*2›’J:’—)na #§*î_ ²}+Ó²’bp)Òu,‚U%òK¢U+ÐnDð,O”[­šKÒIèiÁ_,Ò|PrêCò´Ù’õ-Ð—/æ\$C|påòäödÔE.íTÔ“ Kòøû	2¢„¢äo¦%\$âºn\$¤q#ç(0ÆÈò€<+.ÿN(ìÀc#n”¦Œ¦@®)çgF)“dÙM<@ò0÷fœ_>?î]\r\";†¡ è@Ø`Æy Æ\r`@W+heFXeÊ&\r¥š\r Ì{¥¬&`Œ·‡òªÈ™‡ì˜àª\n€Œ pbˆJ®=o‘J’KÎ” ðk‚:a£\$nXÆKLû-DD ›;óÂÓÆÖdÅÑª@fÔ'²L2\r¢\0E+@Dç3ó¬PäØü£ù+\"Š%*dÜKü-£ì	€Þ¶s¼ß£r8.ÃE³ê=ƒ1ÄìID+°Øô®Üù„&ñàDë@Â€ùÐÙ6äuHHR;.t™Hïª\n†ÆßcD4€@™ŠÞ\ràà˜¥PÓ)Üút‚¥ƒ¸§Œº+!lgÄòï#J,öüÔüB &1j†fÆèj­VÔôÂÂè`rí'ETQ? \nÉ† ê\r¥ä&Ïù4&à–DJ8âlk€:Pöv'g¬H±Ø'Ê‡,lÅË.ô\"NÁõ:ÂÔ”F²–Î'„æ*¤hò/‹#ù dh	\0@š	 t\n`¦";break;case"bg":$f="ÐP´\r›EÑ@4°!Awh Z(&‚Ô~\n‹†faÌÐNÅ`Ñ‚þDˆ…4ÐÕü\"Ð]4\r;Ae2”­a°µ€¢„œ.aÂèúrpº’@×“ˆ|.W.X4òå«FPµ”Ìâ“Ø\$ªhRàsÉÜÊ}@¨Ð—pÙÐ”æB¢4”sE²Î¢7fŠ&EŠ, Ói•X\nFC1 Ôl7còØMEo)_G×ÒèÎ_<‡GÓ­}†Íœ,kë†ŠqPX”}F³+9¤¬7i†£Zè´šiíQ¡³_a·–—ZŠË*¨n^¹ÉÕS¦Ü9¾ÿ£YŸVÚ¨~³]ÐX\\Ró‰6±õÔ}±jâ}	¬lê4v±ø=ˆè†3	´\0ù@D|ÜÂ¤‰³[€’ª’^]#ðs.Õ3dŠ¯m XúÂÉ3’‡²îé \\µ	Òá¦.L\\ÍOºp©¥\r²À…¿ÍBz·.+šÒ¯«‰ºªš¯H’î¿*¬¶A·Îb^Ë¹23r—¹¢J•BÃÇ\"ŠÃÊ”ðLˆ’‰”|ú§Éªf÷šJnäµ‰¬x¢¸Å²d’k’¥ª¤8Ò#èç%5¨Å®%\n¾!,ïü¹AKÍSY0´4¬Ô„ÄóÙ HÆë3Žœ!s¹ I\$*¼Z@òÚ£@B\r,U	‡ƒ@4C(Ì„C@è:˜t…ã½”# Ú4Ã(ä\rãÎŒ£u°<–Èæ4öÐD·ÂHÚ8\rƒ(ÛlŽà^0‡ÁÜ]c Ð7Œ\0è7„¨æ2„˜¢&\r6êãK9)‹-	;ë%NïUEºÁ©Ê£äú]?¸xv²ìòüã8ÛvÒãÍ;Äò@O;D¯Kb¾¬Py\nãä7Z:<ß2úÒ‰:ÕhjÚ>MD\nòy+ u¡¦OñÜ|„#äƒ¶Šj®„êÌ'Ò„ŒÕ¦‰ÅnŠÑúäVÌ/q¬¶•íî;§\rÀM¼'Oa5.Îà®Lþ%åÅE0ŠD “)Ûj>QR	\"±»´\$Ò©#g¾ 0ëjéò[W´‹êT¶/Îa´À¤0BÁIÉº¾c\\\"š•'ÐV”ÇNô\\²GÒûËD½\0V&!±‹ˆ”¿Lš½ÝÅ5GPëKovKPdïµ¤BÊãô”ÕX×°^cµ7€‰UÙ¤Õ¥ \rã/ïïk+‹ô,}ô¸Ÿ–R½o¾ªTR•:gušdLBš&’ˆû\\#ïlÏIß²£RÙsB{¯ùé'pˆŸ»õTH˜Þ°¶öƒ`tM@è¶Ó¾fÊHbô¸¡§>rZ“âue1»ƒLvŒóp8bªJá\r9'ÌŠh6vÕt8Dez&ZK\n;¹fgy4Ä‹È9[À&%çvÈÛ?+Ñ¼ÄD·ÝäJz¦ÔêªcN<S‰i‚+&°~âÔh‘t†ÅñzHâjR+¨òªwO‘É?dÇt¾¼’ê#‰ .!¬ ’›Çn NüNdtÊ¢Ø®OÒá	|‰Aˆò¡AÚNpÕH×©Úáll00“™‚ˆ@a\rÁ¬9‚\0ÌµWêß\rÁœœ´’#k…o†E¤Ê»Wªýq‡0Dƒ\"á!Ñž®åà\\H\nM@R¸­Ë§<§	Œ2r\"\"MãASÊ]Ë4ø‘!<MjÉ“C)îH’Dî8.F›2y&¦Ê¼WËa,EŒ²PwY“=h­5ªµÖÊÛ[¡¹o®_7Aò\rBÆ¨ªŸ„[9—Šó4Ò‚)GW¼iÄ{ò”MMø“ŒÛ(+,W·(áÓ\n oœ¿¸Ã\r)ª;°p®£nTéqW¨`*`0\0Âç\"áÜ4†ÀØ\0Jc‡%Ö¾Cf[¡ÈŽ‡PÆÃ(sa˜:ÖpØÃ:Ð¬l4/ ÐÀ˜a]`€1«Ù¬§ a\rÌæ3žŒ±Vn°õÙ²òò‘™xn&ÌZ) žŽõ='A@\$0ƒäŠ^G†‚Ü\nKÍ\n‡|§@†¸V`g«é~\0äCµe¡œ2¯àµC¤Å\r37ðè,•÷6EPÄ±[z],\niF¢tû¼.%ý”—–íÏóGdÂæ,*AUN’^vViÇÉ¡ Q‘<ö0má¤ˆ®É½ˆPµ'\"éFeY/<§…RÄã¬w!-ù,ÞfÑÉ£MBs*’œñsìÛ\\ã-0°Ëá ãÈ‚\n+˜@¬FxzÜ\n\\@‡×¥_âB¬áä Fi}õÆ#æ5m„å6L\r—™ƒÅÆV›çDÿU::Æ¦Õ(¡ó’ž²TÃV}5[TCb	u9Ì–rèZÉ¡ÆÃ*ZëÐ©£a/)p5ÍÊYöÍ¦REAƒœl\\j	‹‚ÁYfIÂW®0ƒ¨BÃGÊ\$¦	|'¥Jýh²rhìAÚqíbfmÕ¢‚Rj‰>ßcLXÕž“§ö\0¦“°ÙŸ,~qlÙÉA£ßRMÄ0RD©°)œ.~%eSà²{ŸÓD†EÛµNÃžáÖª€×‘õHÂó;Û‘8Xº]ŒÎ2´UÚ‡nÒ¦è‡tîÙTÙ#E1(#¸¶^Ø›n\0oXæ’‰ƒ¹ÃFl×N­š®0‘®ÉÁÂê‚ïE2HÐ!àt¼¦-;+rÖZæçf²×-¤yÔº²F\"o­â+‘N¾.[ˆþ²;,Ã;æ—QQÒUÑÜ”¨²ÃÍ\0ul[ÊŠfbI•tÒ<nsh&¥]´ËŒ»ïÏäSÔ€rB!H‘ëÌXWd‹‚ï âåà_ÑúIí1÷™É»Vî5m;!r>)‹\0»íoe§§¼÷B×Xh¬hr(ÂœZ3Ô·Z÷ýqàŸÕâ3¤‰J0ŽùXv4§gCÄ\rJƒåcWfåÊTœHÂIù\$d'z›ÎY:Ýs€;Ù?\r‰©T¹Æõéˆ¨C	\0€8‡U¤kÍØW ‚êÝpæC…ÏKt2'ˆÉC\nžø[BT|FÈ/–Š¾N3ÍÇT©Û(Q,ž'%e´oÓ;°º\n+{PÆ?ÖMOºýÅLÉLZþJ'êý¼K\$Œ‹B¸ÿ\"ÀÿŒ\"*9ÅLyCžíì,TÌ\0Ë8\"¢ˆhÇºý°ë‰:vÏæ¡ïÎû‡\nÆ08þ0Q\0íÚéB[0>o6ÏDÀò0tì„Ò¯¼&­ò4âÐmnôŒ¤.Ì¦¦#¢ÕÏð5,RÆ|.!</öÕmRì%Ð¶GlÜHbÖæ\rÝâ¿Gg	¬ÞQcænÊ|3ŒÐûv“‡¡	p4Ì+‚\n«#zµB>¦L;M>+£üÅ†Ê=Í†æÏ<6Ch‰°¦Ó§\$@BjÑ(jïÞ¥‹øë\$\"bâB±,jÑ2—¬†ænt¿±*„G6ªdÜ©\\Üê|‡&-ÙŽÄç¨0Â\"¹B®ðLÝqt.'UÉGöŽ\\Ò*g,Vç‡„ÅL±Œ}ÍÄí\n€­HxW-()(\\È¦Ò+Â„q\$œ‰ÄL¾ªŒT«É\rÃ‚€ä\rààã/fíª8ät…KÈÔf4ê®‘ÄÎ}¦Õd¹¨\nìîàÉ+ååMQ.³‚â7F¢Ó­`íXTF¨+í@,ÀPnPPOM`\0SPÛðFýíéñ6ãQ~+\$|.2PÂòTƒ¤	Q’8Â”jÆÄzCÒÛÇø rVÈ‘7/j'­²gÍÄß²Yªvá1™'çÚ\r£q‘Í£ÐªôÒ±(®\0‚B£)2¨bR­)’pàq—R¨‡B†B»EI+*w.\"¼Ì\rJcoRnF.&Pü¨¸;ð ÿr`Oý.²ZÂðËèzÝA/«K/áa0/Ó\nIäÔÿB»­\nKÏûÒÃ*5+s¨tð¢ ÑÕ’Ù\",a-í\r5o5²³(ÒÉ Q®jf›#­Âdæl¤xà\" à¢©èª#|ÌS2–ÜtÃ@r¢l æ¢Df'9J¦aäH²ã? GXÓ§•kfŸs„S†DÙ;PtH£xlr’‰Íé3âÁ4/;qžçó %çÕ<îö|&uÍn*/'3Á7¢²ëæE‘w5Ò£-¤v–ŽºEM-r]4ÏûA\ryBs]7«Aç(ôöîÝB#eCï^vnç)ðÞKÔ,Â0«DÈùE	s(“HdÓ`—Ô`§´d‡Ò×C‡¿)4_	Øe'æõÔbui70‡H§	DçPÇæÊ*->ic¦#rqÐúV-LBÇâèãd¦Ã¶Rk4ÓOQ8Ó'6”5.ÓJéÓO6S#LÏW6ÓFÈ{63äàƒeN1£CrÇC´í?§ÊÈÐˆoÈ?¥	HNø|Ò/”á2”?ITEPd oå¨!Dí/tßO5n60dB+oO ô2çL_òBGEhD&r¹&&3T”%TËÊmƒ\0 t{O´1êˆ3dVl¬åµmUTÓNgÇNª·Qüí²VQV•…ˆI-ñR,gYÇMZóXoG\"“ÕBˆŒ%ÔZ+R&»ô6õu)=YU±QõªwÕÜj/õ‚ºñ•ÏXÕZsô.u/ò•‹FµŽÆQ_Õìñi_F‘¦Þõw`®Q58­0òj[^m^CÀòUîkVÝ4‘HÔtu,ÓVÉ,ÕERsE”Ù_¶F÷VL•¶Q5õ†•bF–\\µVOaD“–!Bâ©zw¢ís%ONb½Â\nbîjA®\"Š\$'M\"õ\$\\Œr¢Hÿ°W*6¨ÆRsóòËbîAS<æóÄ³nmQ\"käbÙ°AHODÅFmf0G3%\\–·nm‚fÔ&ÜÅM0³;k|…@Øbú:bbÙfbáÆ×ZE+h¦ÛS´¶”\"+TH,ÞeJ Kó²?It>€ª\n€Œ p’Èp³ntaPCT¿gS¶¼(ÆìŒoí±wp¹'lùv‡¥Â@\$Bˆ©z)ÑÑ´–Â‘‰¿]“þÿôB=ÐuWÃjS.½µ?ðÊ„„PAdXÀEzõ\n`D¦Ó_]§´Þ„[+Í0µ'ˆyÕ}C'@äó)±ÿZñNl¤\\Þ—èKÄô½&ù¨¶³*oCTOG>Î}R¨®érwd9'º½Qo>øŸq]l´/åÇ¸+u\rƒuuç\r×QrÜ83+ew	ƒøS¸VTÈ–Ëˆ¾ÄÌS„îÆÅIEÔtÍq”Å3‘ñ}2l‰×q‹Â\0Q…8~Á è1C\$m;}DÂŸí\\èv\"D’ËldQdæK÷SxÆNáÑõ[#”æí@\$…Bj6Ñi‰:‰­^BÖ„næ´4	mæïaî&!/:“Œ¦&ï:†Ø\$z15-’v/nf*Œ0c=Af¦ïdàö<ØC‚˜Õ„¹0o½	)Z5R‰¦^MòùY6TÁg¸È0VToƒ€";break;case"bn":$f="àS)\nt]\0_ˆ 	XD)L¨„@Ð4l5€ÁBQpÌÌ 9‚ \n¸ú\0‡€,¡ÈhªSEÀ0èb™a%‡. ÑH¶\0¬‡.bÓÅ2n‡‡DÒe*’D¦M¨ŠÉ,OJÃ°„v§˜©”Ñ…\$:IK“Êg5U4¡Lœ	Nd!u>Ï&¶ËÔöå„Òa\\­@'Jx¬ÉS¤Ñí4ÐP²D§±©êêzê¦.SÉõE<ùOS«éékbÊOÌafêhb\0§Bïðør¦ª)—öªå²QŒÁWð²ëE‹{K§ÔPP~Í9\\§ël*‹_W	ãÞ7ôâÉ¼ê 4NÆQ¸Þ 8'cI°Êg2œÄO9Ôàd0<‡CA§ä:#Üº¸%3–©5Š!n€nJµmk”Åü©,qŸÁî«@á­‹œ(n+LÝ9ˆx£¡ÎkŠIÁÐ2ÁL\0I¡Î#VÜ¦ì#`¬æ¬ž‡B›Ä4Ã:žÐ ª,X‘¶í2À§§Î,(_)ìã7*¬è¶n¢\rÁ%3l¥ÃM”|¨ \r²öã¢m¢ä‡KÑKp€LKÂúÙC	‹€S.ëIL•FsÔW9ÊSÁ°³“TŒJzÜDÈËdz¾6­ò[Àí\$ßK‘û¬ŒÓl÷CÔT»ODu;t§««tÖIÑTÒˆJ©î}F¶ ñC\rYÔËÄNÝÍ5,áaR‹nWF3ò‰,ÏÔ²L-õÕ?Ö+Å –­ŠpSÍv”ÞP©å\nÙrÃ”a8§Ää½TAÓyJªÜ’xÞ`Px0¼Ê3¡Ð:ƒ€æáxï‡…ÃÈ6Éƒ(ä\rãÎŒ£v8<?Cpæ4øðD¹ÂHÚ8=Ãn::xÂ./–\\þ\rã#æúŽo ¦(‰ƒKõXw½FÄØQë\nÜ¯»i@G¤ZŸyÅlãQ\$_,#M[7¸‹ÄD¥Ð¾¢§ÎKssdQ\\?p8»KZGêöŸUÙ]óUÙ¬2\nãä7Iƒ:BçPã‹[<DñXMj‹A—3%`mU'·³z=Ôw®—\\ÆPLÞëÑ\\{\\€2,*¯Yˆ˜Â:ƒ @;#`ê2îšJ¦¶i×¤¨âÀó¬Í· |§9F/üsDØV\nñ Ã(ÝñJö¿H»¾û{¸µ­£Lü)„ÉÓ§e2…ô8¥Åê@}6VÓ70ªÖ dE7“\n#Dý‚ÈEÈ¬äghš=Ä€1†Ü’Z\0-MÄÅ|«õN)Ä£6he§ „ˆz‚™uUØèqp@­¼S6ð·]€YIç …\n#ŸxäÕ³œÞMaš\$oÏé\$ ù‰’ë-†r–¸~F‘¨(Ž S%–ØmÕñn}Ê`™‚ÂÒ“‰OMeÅçö¤\\ÊŒmfò!¿¸Œšaì\$‰G&\$`1M1äu‘[M:Ô9\0£ºwÜä\rá˜3Æ*Ñà¦%‚™l	ðyç\r°8<‚\0êÈƒ¨cgÄ9†gh`oé09‚Ãæ¤èaá…&	jã˜ n§è0RÑ\nÛ ˆ‚œ0¦‚2{¦´·šY£9%n)?CRðÕ‘xàPrFIÉV¾ˆoxï­ù¨Ó·%Ïn\rgÈ31™<ÈÒh ,MŠ‡)\\Ù+#ŒX/öÀØ)r@ø22SòáY‹3h†·'Rð­Q™4º¢DÔ`·(*åFb÷+ˆ“i”D—Šf©3[1J38§ÐÂÏÐr=¼9‡v2Îƒ(x¥@]?X\0h`Lƒ0†ÃsbRå‹1†4Çõ9d,’‚öNÙK+e¬¾„³DîÍÃC9g`‚M†³ÈÐC“a¹—Ð³nñ•j0¯ã•É )M”…ÅQ„¾lŒ`T\r0†0èÉp ç¶#È´íL¹ÍLI¡”aÎRÊyS*ìM‹?‡ÎÁ’\0ÂË\0c§¬¼4»æÑ“WŒeûr•Cš»d\$ïœé‚\0 …qdTÏ\0\\å¶æ\0 S5‘¹\\¨µ|?uºbÊpCdµ²Ã8ZÆzOYí=á•2‘þ<¡½Û;™Rï#D3ÉE¶Âå–¸á<€]J`•Ô¢h\n\"¸³Aa%c\nLî96:²‘Šg^²\nÊT/ú!L?„\"œÒˆïl€/*:b¦y\0¿´«á—Ô¸:wæ±šº£^Öq\rÃt®mà’GÃÉÞ4³£Ìí™èngGòõ0 âîé€ ÁÈ7†Ùå=+e2?ŒvÔÊ–{i/Pp–A•¢*\$¢PT%–ø'…0¨C¡+Í*¸†9Bh…2#¤ØR”3ˆˆài˜µ@¢Î²¢æ¡¶äŒH#CqsøMø?;5)j`tže½‰\0ƒHgü&d«Äííh ÁRàÀætY]ç–ÎÛ%äÒ@Å.Ïî”&è2 ±a™„Hèg†ï\$Î\"êQ’[_<xKÖÄM0p¯©Ã²A¢”ZG`¬‹òmÖåºË}¬DI\0ÿ]¾8P=¢Â‘Þ”n\nn'W2Ù¶Šé…sâÁºA‚‡‡‚öÝûíÏ#2Ÿ0N!QÚpŽùÆÌÒ³£¤XÆ«¦9—ˆê¶^F)O”KNi £ åÔW¨ãc›sW	]Í\"?â¹ÝáäHä#‡E‚@…>ÞHEIï˜µËÍ)Xnh•“W\$òSäzRIë—ˆ·VÓõ0È3Y\\íýÁÁ1’Ú¨Ë—8vvÛ*Ïø‡`+¤QÈÙòO„c.Ò‘IZ¢è€)Qô(ÁlåµÊnÐi!gF¢0‰ùÿ}I\$4‡§yv™\\»wL2žë\ryZQ£ÝB%^U0LäÃÝ°Éøðº]LmlŽïÌèöPî×‰-«»¯TE÷·yPûÓ¤WÐTßn\rˆì”õ0)Äq‚^!½%ôc/³r¾5kWMó‚DÜí_”¥~ëÍtš?Cd…¹Ÿ\$;mJnã‹Ç#zÇAä,§ÍÞfŽÊs†¿¾ÒžI)]çÕ—ž‘ÕŠ#‘+ÿ×ƒ¦®vþÅ°Héªn®dƒ\r@‚\n€¨ †	\0@Èæ,\r#âÒÆ½l€>ËÌCô§Ëxëí¤ÆêñŽ\nPé¦œÎqÀ^6q%–Úa~q°Xì¨lkïê¶(*ý¥Ìù„öh^œp<-ÏéðbWCtyçØZ‡ÀnÆ‚°€ÄH('ÐpÏd…¤BjéÈ6ð‚.0†VC±\nÐŽ‰bÈ£p˜ áo^l®å¡\0n´ '¸·¨üš&°Ñ\rž/#Óˆ\$tÈ(èn6[Ptø„O	Q\n£ˆÞ0±ðÌ(ð`Óh#\n0nè@õN&@¢ÏpÄßòœnð²ã¡÷âˆø/˜û`h&(vÌ˜âBxc´€/BÂíO‰ðH¯¬rçºÁbo%vÄÈEJôl±qåé\"zSBhÂÜ™‚ž¿n70d[…\nþÂT.MfqhØiÅŒ-„`n¥&nÄ×ã0-Ä¬ñ‘˜Ù«¨kmxnÃ&¿âØæTçÚþ0ŠÑBÜkBñ/ìÂîÆýÄ\n/W\0ä\n&¦Ûpx8Å» Æð„.¾oˆr¥N(nÏâñÐˆQ?	®<Uå„oD×R& JØ#nºÎR¯lO°LPo×\$o®`J/é¥–Hc¤’Vœ±ŒãéÊýfÚJß5#2U#rŠœîêôŒÐÖl‘‡’}	ÏG	(Øæ\nòS'’•%².îÛ[Å¬ý‡ÈY\rÒØç†ÀÄââ‡ÂŽì˜j#RÊ×†îTŠI\râð2oÚ¢h¤‚å\"#\rÉ.ïó0Ç:ë-´Û‡¤8òjïoXÞçác\r)Àö’ˆò“RÀôÓ)g^5hG!€\0PÑP\n0­ÀKàRw²Ì‰,ÜäHš+ïJoã53Ò~á“få¥Ý,ƒ&mÚ“8BÓ9+Óy*Ódè®ÌHÑí+r§	r«#³šå“ž-ò n#³:r{S˜ß#\nˆã\"³o(Ï3°þÅ#’™<O)/Ó¢€3¼LN9=ÐÑ>÷<³1!o…'’ºãSï)só!Þâ²ó\r‘nŽw%¶qÎñ¦!³S2Ár¹ìPæ±ýk;ñ@Æ° Cñ-D.m´:“À£ð¸S±ó³éB³#BðCPÄXT;+ózxe7°\r6Ò—#\nK9T<\"ÏGpÙG®#30zˆTOCÓðPtŠ¶Ç¸òµ\n““*”S=ã‹ëhUCrTX\\Ã\nÃÅmD¥7f-¬Ðá´ÂPÁUbØ&®`ñ„Ä‰Š@ÿÓÄ­‡LÓBÔÐPÊ‰Ï[IÑKâHÑ¯HÑ:*1xØEmE®n¾0ôZ|ð&²x¤QÞý¢J\riG„‚s4ò¤ÒN™Rœm“Šˆpß®èÙsNÂO°â\rÒŠÅ¯;s5*T¯E>Puh’“ÍGîÙ)…:³ßW¦½\0”­A“;Hs¬éC>h‹!ÂÜ3Éšÿ5~âÕƒH4±Wn?ZkmZÓû5oIÛ[tŸ[±’ÿÞºÔ«Z5sIÔPu½]E#VÔ—%OšûíZ‡;^µ‘]ÔùÁL£¢þD8¬èXa~æ‡¡‡µ¶/Fë£=h	\rÄtúäŒ„(ûE@ñÈþU¯\"õ²rõ—X“òþ\"jò\\Uï@ËWUÏdFjõÚG²¹f5á3ñ\\üveweÒW_V5b¢YØÅpÁUÃ“7h±¶/‹fÇóY5óa„i3dYš[–n_L7_H¨ÚéÅM¯ìsmŠâªîÃNµ\"Óq(õµ 4gLÄfím­·Z¯>ª9fv×o,LÕíhuÉ'tET³?6ðJ6õp–Ÿ*7Ž7¹WrÛvÇTQmMô}[sXW=—PhN-×=s6û]óíqU¹s”Ü†µUˆu!×N%¶ùlV¤ùî×T­söIt6çgtrÿÇØú7I3ý;·Y9u›È¨Ð2ûl4‘I´q<7 #¥i×•hSÿvÑ€ú°Ýz–scðÒÙUçZµ×,ðRß<ïnVMXwK]\rÔâÝe¶¡h—­yÓÞRçÉ|v¯`ûY“Þ}p¦YqieTñ-F¦Ã0?-Õ@å„3ÍutYÌL¡ƒ5Òr”1!åb÷²ßy¸\rD!´fz8*=BØBýb•„„ÕoØNPhÈî5Z*,+âÂMaEt##ÒÕ\"×\0øSP2°Òa\"Mû\$”2z7ve)``è@Ø`Æ‘ÀÆ\r`@d­,vçrwjÆ\r¦r\r Ì“¦„. ŒÓàÚ¬’±Él± ª\n€Œ p:ŸxI¢ë‰,eEÐgFöO˜B-Èº6rñ†ÖP)±B#«Ø_F9}(Ì®XKYWéuò›‰fÚ)NJMìx*õNcÎ2 Û`	¸ÓqE\rY45™cIWødÐñ“nät#VÞS/­Ðë—#;–¢üAL%vuOÚL7Ý_3ò3_†‰°ƒ°è7*0-Áoí(gXÑ£ð@¸bG–¬PÅDß9-‘/*øDm¢Œ8±ð;YK9Ý(O&Õ-ñ:Þvýb×ëžîîBã‰÷û =xÕN¤´cdvã=9;f`¨P&<#ÆÊ€Þb6h’ƒ lPÑ“Yø>è9?ópzÂ\0{¤ <(„Ó¯OÜ23V Z9’Î)U¹pUE¹§é§n6)ç>hÄ¿ZèÈãô&V`¬° ê ÚßæáA9v…8‰Sbõ›DU/]•X˜ÿê'\r§Òãùâ/æ·w©zj„î‹9óŸk¯‚YýsoºÏ-ö|µX[–²PªÉÃq×`ê*ß/ZXÀæ¤EaÐàõú 	\0t	 š@¦\n`";break;case"bs":$f="D0ˆ\r†‘Ìèe‚šLçS‘¸Ò?	EÃ34S6MÆ¨AÂt7ÁÍpˆtp@u9œ¦Ãx¸N0šŽÆV\"d7žŽÆódpÝ™ÀØˆÓLüAH¡a)Ì….€RL¦¸	ºp7Áæ£L¸X\nFC1 Ôl7AG‘„ôn7‚ç(UÂlŒ§¡ÐÂb•˜eÄ“Ñ´Ó>4‚Š¦Ó)Òy½ˆFYÁÛ\n,›Î¢A†f ¸-†“±¤Øe3™NwÓ|œáH„\r]øÅ§—Ì43®XÕÝ£w³ÏA!“D‰–6eào7ÜY>9Ž‚àqÃ\$ÑÐÝiMÆpVÅtb¨q\$«Ù¤Ö\n%Üö‡LI6xi6ˆ\r(1¦;ˆÐ@7Œ\0Âä2Ê @¦ªúB©¨óD¬¤\nâ\\**h3àþ!ÊÖ‚>ŠÃJ¼ŽJØ¨Ž¯Ê;.ˆã¼®Èjâ&²f)|0B8Ê7±ƒ¤[	›Á!\r¨¸Ê9&c”6ºpéý¸±x˜œ¨ª¢ò· *Â0ÊÂ„~ËB¢Ú5(ÍÔÏGâ42c0z\r è8aÐ^ŽóÈ\\0ŒŒ2¬9Ë˜Î¹Ô ðƒÃ˜Ò7ÁxD¦‡ÂHÚ84ì`Ü:xÂAm\\z4@bN9¡˜£  ìô¿Èè\$´¤`T¼÷1³³£Xè† Pƒ!ƒLÇ	Œí8É_X¥†Û%uèœ7²È*ü;JÂ¸Â†¨£8æˆÀ£b:!-»oŒ7\rÆ5\$ö6E)üÂ4ŽÝ,¿IBê­Úô¯Íøˆ2ŒÃê6-v:%XºB0ê7\rcðKƒ­)3¹õ“'#<p14ÍhÎ2#•’ææ&+á>&#ªjèëj1Ç ë[(É‘_b,<p)lš™\$ÏÝ&Ó±ÍXÓ¢õ;õ#Hòä:'xbS±5ù}`ØvðôÍÕëô­­kŽ#Ò2µèŒ¹°ÖÏ´F)A´ :ò¯#òæjœ§z`ªO*tœ¥ã\nØä¯º]{¯K;ÆÅšˆ[Žæ6ÇMVÀa˜\$”Ì³vº7ŒÃ2«%Â~I4L#{[Ê\rÃÊODŽ£ÆÕc6\rã:Š9…‹èå×c£\nŠâÐ\\?^ã(P9…)pœ2²Ñ³¼‚b˜¤#iã \\KÊË¶Ê?Ûºà„6Ø:¥ÂªR2½*4	3²Ð»;ˆ50åQÛ!\0ƒ>¨²?zÔbŠ;¯Ý5ÄÚ›Êh\"ÄàŸŸCÆ¦TÙ.\nÊÔPH¢“:\0!	5‘—z™ŽIÿTˆMñ’ÐP9~ì¬9‡0î\\Ð(eÁaG·Sc\0MéÅ9§TîžCº{‰ý@‡%¡a’ˆQJ1G)\$¥AÎS\niNÐ@§Õ	 Šér\r°RTdR%ÇØ¶ŸôxîYp‡?Ê¹#ÒÌÚ« ¦©‰¿\"CôQ€€;š`Ø¢HïØÆ PÂ¡Qv.Î»hþKÓÅ¦È¾†‚Ã	ŒŒÉÕ.K¸s%Åè¾„¶•‚s#ÏP¥¨ÜÈph{ (wÞ–Ä‹¢\\ÔaV/æ-3JiÍJ+È:³hh	 .ä°;Ãb^ô¨¾;Äu¾ÀÊK’ótlï“9@Ö¢œ l!Ò†©làÉéÎ\r2È¬Ó±?&ôï-òƒ)&h£†”\n\\*¤\rÈÙLó&C©ª`¡™Ÿ—öŸ’<•9Òl–B:jÙY©œL žâxS\nˆNS½¸ÈGÈìu…pÿ¶¸qH&dÖ0dZeiá¸3¢YV ¦M]Iÿ(ŒÅf‹Äù4¤\n\n˜&>SLB\r)ÁRZµ£2Ø)þ|´V9¤„ŽnXäëƒ¡©—× bB™mÄlÒ¦JÂp \n¡@\"¨A\0(4d\r£ 0æLÑ²h#a„€«\0 E	ÃØ›{‘äì6•úÊ8Pôizì\r¥ZÓZ†V[QémDìÜ_k,“%âw©TôÙ1ÖU¨vOpX™t¸„á¿AÕb^y´põíº¥ŠXÞJ¤£-ÍÞSÁc6å=£tŽ	…¾\0[›SlXG¯6	n•‚œ4“¬Ñ\"YŽíÂ\rÄö§rü®ÖÜVI63ƒ¥:„Ãho&¦l(KIlRQL[jÍø’U~)¶ZÇ¾ËjEëÕ|2Ìd*4´†Ž„ÀRo&òr4\\O1è=NIºK’Mt±	—…ªP<PM(eì™b™DÂÒÑÀI¡he¬¬›×;Š)Ýœì%Á¤ †iûdYL¦Ý‘ë{\\H%s®¶Y‘â†bréÄ\rù”à¦ÆQ‰š«<¤¤Ú0ÖØGÀPR^ïõ»“v\$I‰‰\n\rá‰õ¡˜PáîWÁP*†U¦ªi9¡BXµhšÌÅö\nfØ±þW«ˆð@·‘”\\Ú¤j¹:´ÀU†Œ“ˆhGi­rÈ²q»ÝI'`ÔÒÉÌÈ\0eZµ®t×„Ðë¸Ü(Nv¾@²vïl&·–ÉþÅØúÐ„kf'®N):ÙûEãjÍa°fËe.ŒÈ´f¢A#–Î=6HŽíI¨vâ£Öúwfî)Ç±w¾³Ú»{eïÝy´6Î«ßdï½Á¼¸D&0œÄ¤ÁQ(w[db¿S¤•‚yVÁ\$-—šLv¸éGAÄˆË›ªÚ’Y¯+BL0`Ê¹zG¿­¡Bƒã€\nL	*âéc-gFºxè+2¨×íì™d]-X„ƒæ|“8t²Ùœþ¸+ôvIþ3ØF\r‡«Ã&6ÏbZœ3²ß¢}ËVš\nŠÜ•Î3/‰LØ7&®ï’;Ù…bg?´÷ƒ°Z¿vyÅºÔ,Æ˜A§k&…µ¯Ü,GX)ød¨'Ñ¢Pà§H†ƒŒNœ•%éLšK^ o3æÌNJÊJ*EnÝ<ºðxžÍ.µÚ@A@d¶…ÚÊ©# ®µ6ì›‡³÷ëµ¾Wl¾¡”üíaÚ~GÐ½ÿKÄðƒ/ö\\mÝð>ß´·,kû7}ü®Oîw_¼K¿3”ü~·Îs¡Ù1:ïÛ9g²~ÚMXÝ\r†—ÀÐoô(ÂLÿ¨0\0ÚjÝ-°+°\no÷/ýÊÕå¢\$Ð ½mÖ¿ÆdÌ\"z®¯ù Ü®B?PF(oæ'Â}5JéŽè‚ƒœUFª©BbBz©O|µbÁ\$Æ3f@>ƒŠ+@Î/¥áxL‚âFêovÉ†d \"×bæg/\nB\nO‰^#èØÂÊ“l°¼`¦ÌUaL¯¢ñÇ*ðCÏ¬¼µ%ÚW­È¤\nýÈþÐù¯ÕŒñÝç\nºhÙŒúcÁˆÐ	ÜýL*ýã‰ÏéwÑ!ÐmåÚìž–Ñ8e\"aQHÏæRÐb†1¤¸>Æ\"ä1.†òelB`@Un1®‚ÏPKÄ2ñ|.ÐZ9ÏêÏ0/Ï&ÊÇlbrW¬µbØ\rçføOúÎÈÁqžgªéFÚ8‘«åxdÄX#éÖD\"^rÑ€í‚L=âù]¦Xbp1N¯CŒrÅÞóñ%`D1”á]#‰Eþ¨¢=\$@^È Ãƒ©}\"lÌ±Šð‡JÍh’ñÌ×\"‚‡G\$²2õª~Eñ7C~>\$˜!Ëé kÄ%Òd6’i#p^C÷&cÝ ñ	\r;ÂãeÜ·ià1 ž+\0ôÿ\rIm(Ö¤>\rÅîà	”¾ÃTàrª^ãÕr¤æ²¨(¥î„ÆlRŒžErbÃB\\Cd~Ô„ùp;\nò°ZNÆ’ç;\0gHÕræ 9/ˆLd|\r€Vƒ²‚Î^B‘sè9ÇÐaª¾ŠâP`©x`ª\n€Œ pœ€F<mìÚc(Ø)øzPNÕÃ(àk ›N×ã(Üík5¯¬yÐ‚TÜ&mï%z0€Ú'Ã tÊ‚1',ëä–>dV/hã1Ëô3e ó	Tö`]Â°·Ã¸²cÌå¦“\$\0\rãÒºç;b‰;¤ŠvcZ2f¾`ŒððÃNö¬p›/›ìŽï2ôús‚Ó®K>“Ý>åÛ<]?ŒM>Ò¼T>Ïj\ràà>ƒ\r)ï.BôeŒÐF6_kk<BF\$óz0')LfÆpü+°f¯†(Ì¢C&~%€Ä@ƒBú,ó6\$À‚`Æ¤R¶ôrÀêË\"~ÇÒÒ{ ì#†ÐqÎg-ô(m&?´4ò`ê!kÎkóÄoF5I8ë£.mt1 ¤@é–ÈÀ«1®~§Æ&Eâ¬";break;case"ca":$f="E9j˜€æe3NCðP”\\33AD“iÀÞs9šLFÃ(€Âd5MÇC	È@e6Æ“¡àÊr‰†´Òdš`gƒI¶hp—›L§9¡’Q*–K¤Ì5LŒ œÈS,¦W-—ˆ\rÆù<òe4ž&\"ÀPÀb2£a¸àr\n1e€£yÈÒg4›Œ&ÀQ:¸h4ˆ\rC„à ’M†¡’Xa‰› ç+âûÀàÄ\\>RñÊLK&ó®ÂvŽÖÄ±ØÓ3ÐñÃ©ÂptŽ0Y\$lË1\"Pò ƒ„ådøé\$ŒÄš`o9>UÃ^yÅ==äÎ\n)ínÔ+OoŸŠ§M|°õ)àN°S†,ê,}†ÏtÒD¢£¨â\n2\rÃ\$4ì’ 9ªŠ²’¬I¤4«ë\nb!£îÒ†\nƒHàù„\nxØ¾cªJ4²ãhÄÊnxÂ’8ÌêÈKÌN	(ðÈã+Ð2Ž‹³ &?ŠüZø«ïH¦—µÃ\"ëÄ1 ç.ÀP‡È#\n71¤´Ž©éÂ‰#pÒ1)£ƒ(hÉ†Y¼hÓ7µjÂ7;C &ƒC(3¡Ð:ƒ€æáxïE…Èúm<&¨Î»T¤\ní#0H^*!ò(úŒªFã}¦²\0Ð7Œ›òƒ„˜¢&%üâŽsD¢Ã1hš‹Ë!F¡È#¨Æ:!L…~Ç%l-„š5È\r•V\r6lÔš1,[.Ò¥ò\né,Ì7ñhKVŒCËpÜáÒÜE²¸Ø:«Ô9>r´~‘Æó(ÆÊTC¢<ý=Ø1¹ã(Ì0±Xì½Ž£-n2×0Eì#\$UÓ\$#;<0Í|¬—° Rh8ÄÃb;\réHØ6\rø@ž9(×´Æ1»Y¬ô&ejmÁ+Å‘V¨ÉKqã˜®EŒeì@Âß Ì(Üfc#)XÖk¤W‰Lv™3Ú÷t¿ÌèeÚ»„¨yEBÈl£ü7\$ãžÜô ¼gìU„Ã³\n\rk^„Bˆš*º¤€PŠ<\"Ã—¸Œ»±†[CÇ¿Ìnx…ÅnØ‹ÒÏB’66H SFÒ¤¨èÞ3Ïäðà(c<Xì€¨7«‰ô¸ü²V6pŒÌU„7¯“ñ (ðÎ0¯.6évÑïÐÊaJcÛnÐ@!ŠbçÈø2Án9/HòN75É*N«.£köŸd7O	äéÙL§jõÌn\rd3U^w\0AŠ<—Ÿ‡îFJ1&O†	?¨¢òN/G±r*ELLIšl#	ÌYšbºHrEïº¾“¢™“A%©áÞÆÎ–Á&	h9‡rê«P\$(2A4üÂ”\nƒPªD¨°î£`Yy%à¹I)@Ü¥2™Šêp9©â*GTåET›¥X«‰óÙ8Ì 'tžP¹{\r¹ºžÂ`ci:¢žAá	Aˆp4Ö@{H æ¼”†\";`,nª´0†hrAòmx,¹â<ÙnŒD… Á„¡¸†žSK*Ž&E˜HeÌ™0†²,#e+TÃ ¡@\$Üj/W €RˆP¡LÆù»6):®5¤×	&jÜAB…h7°\"öÌ¼“Bòœ7CTø7aL™¨xËIcï›ˆ©«“¡@Olµ0¤UüÀÉ4*\$Ä\$‘òi&B­+l	-ªÓu6Ì£n \$¨9ˆT„¡{A˜+\n}	±„É1  Â˜T É½ºâ0MòwŸ¡JI±Ã-ŠtÃ+…å­åøßsþ=Œ>} ’VBaS!„´\rÓP†¤~O¨o#ï¨1v°\nA´`©/“º­'®5OÍEgÉ“5Á+hŒÓÂ-vDV£j”Õp \n¡@\"¨kÀ &Zþ”„e«Ñ{éòÑMY% e	Ñ#žY8jÁ\"Ð‚ˆAÕ%'\\ìœå~ê	{OVžª<Ã,xf™ä2Á	Ë¶TÇ:ã†Ó²\0É‹c<P}¤–Ø¡“–®Ñ4rÍúâ/å\rnµ¤¨µ\":ökŠm\"à(+\"vž€œá\$OAX—¦ê–¡ÕD¤M®\\ tèSåä¾*+éüLô^fÏ@:A`*šVwbÜD;x¬‚W…G(†ÏˆzbI\\Š½&&±ä™à<DôÊ¹Æõn1	¨¼—ÊÓ‚•i®¡Þî]d8å€Ã¡¸£…|µ³ï ¬÷ DZ’Ã	 ,õ³ãÀÇ-±¦çüÍŸbU\\€AXóP—[=NQ\"#Ù-‡¤àäâƒs/#S§XÜÖøSqÜÈcŒ¾ž‚‘úŠH´\"š‚F‹B#fr\rÍW¥DQ_‚ Aa\"9±ìlLÜ¡†Ö²N'ÿ`3ÚMp=†™ÚÁ\rU®€ÐUÙ¤Ü&•^2F•Ö(~ˆýŠ·Ù€Ÿ…Û¥5ÇÆ:à•Ýë¤BD¸1êq~5µÔ¥CL÷DACn«Eò\rzçXIùY@š|’VÅÛ£5–žÖ¤“[¿Ê…)#†—¿Åxm-ll¶¶¤Ž+ZjdOgöx\$a”Š¹J&@œ2nÙË	%®ñ¼±Ô¶B‰•5	Tn‡Y&tžy&Œ–BµpbM8CäÙˆIŒ®VD*}f\"Š¹bM”‰}ÊêüÐB¶NŠn2\$ú 9\"ÐèF²HXJØáPŠs-UfÍ=[Âh”Íc?½‘ƒqóì¦²Ùý`K¢;;ay“¼]ŸJ™Ñºã¸Mùôó5°Zþ¬o‹fÝõ	Läz_\\1dÆÇKT×Ù\0VÁ‰>î³[—›% Â>Š˜r¢C1²‡n93Ë¤Øä\n\n•ƒË«€IÿŒð¬‹ºäãÁÔ)nÂ`D£ŠÜk‹žºø)ÀŸbÕô¼×©4ÁrÀêJ)òæk¬îŽÓt\\ÅÅörÍö&Ÿ6Jy?n¹VÖÔ¦>¼a—·¹i‚æü}UØoºkùwI^üïkÐ–mÿ:žýÙö‰÷Îì\r§±}–õ8ó'»”Ù“Û‡,Ô^µ6½t3×ÍjîŒ¿ÿc|ýÐp0ÿ@ÕXùïÈØo¬Âo°0ŒŒ’\$îì®¾óFø£†ÈèT/O¸ù0,¤b\nvOP® @.¢î{CLb£Lnˆþ++ 'Ãp¦ãØCàæ?\r±oRßÐJ„ÀÈûíšyÌZÔ\$b¸+¦ÿæ%ã´†+n·°rBb…\$/&vÌPºEˆÇ„0÷¬€´,†}08±ƒàìÏÆZÏnZ\"I\0«+­®ÐoÄ†ÌæºÖýO®¸ØÍÍZýP¾l—nŠìÏ» ËŒ4ØKÙ„¬¹îAŒ;L¸É#\nrÄ¬Ô+è­GÜ£l#›ëoþýð'0MoöFÐÐú\"i0(Ç¯ o‡‚ÞæDmb(ë°g`1\nr+¡jï\r¬¥)&ÂƒœC°aNæ}_Êo‚#°aPÞñ:ìñHM‘”‘™ÏÅî~±§¨c1RMq“qš†1jrQ¥QÎ´÷ãôQG^>q½\0iå+Ì¥ÑÔöÆÖì˜ÊÑ®úóÌª.±ß® Q„G ŒšÊñtn’ÊÄ8T%qQë3\$J~íä¤ÎÒ¤§#ÀKI\n‹ù€ð&Íþ\rç²ýD^Y&]±b)„.}\"N2¾òp¢§~b/	¥vÒN6îbH/Ž0Y2? Mx}îªþÏ1\0PÁ*%º`)ð\"\nÊ@†H Øj8LçÔÊFîÎñã\n@Zfbá\n´~J&‘Çœ¯@¨ÀZÖvC\\œ¬g(äÒ²¨·³\0qÓM|EŠpèFj¹,}ÎÞÅÀò¿‚PÀ§=cÚƒÞ½Œ²1l¸J1z©RÒØBL*\$aÂ÷ Ï1fl\$£(…BdªEZØ&®6ä‡7C¼R”@iÎE„*«þécd[/u'­ü>¬¶ï£9ìrªvHQ:ãy;/Žnã9Ó¾1OtÀÃ| £5Ü§´˜Ø&Ì@zó²F0ÄC`†d…x¶í;ÌÅñ‡7/ZhnÜ¤†Ì	†‚õÆˆ@/HóÏL v0&^\r\"bRàCkºÖ¥è³sâ?¦8/Cù4C ¼‚ìZÓ4ðc  9lu:‘,¨\\tŽ4úorÎ‡EÓ¬JÎc;¤ãqÆ\r\$6	fJ ‚wT`\$BWdô	\0@š	 t\n`¦";break;case"cs":$f="O8Œ'c!Ô~\n‹†faÌN2œ\ræC2i6á¦Q¸Âh90Ô'Hi¼êb7œ…À¢i„ði6È†æ´A;Í†Y¢„@v2›\r&³yÎHs“JGQª8%9¥e:L¦:e2ËèÇZt¬@\nFC1 Ôl7APèÉ4TÚØªùÍ¾j\nb¯dWeH€èa1M†³Ì¬«šN€¢´eŠ¾Å^/Jà‚-{ÂJâpßlPÌDÜÒle2bçcèu:F¯ø×\rŽÈbÊ»ŒP€Ã77šàLDn¯[?j1F¤»7ã÷»ó¶òI61T7r©¬Ù{‘FÁE3i„õ­¼Ç“^0òbbÊ*,ÔÛÀ:ôGHå:Þ¦Aˆ7mXÊ5„\n‚¦ªŽNJ´×««Á02Ž ô1Œ®{¤Ö?ƒ`æ5˜kèè<ŽÈb‰¨æ6 PˆÖŽ¯»~â(p„4§£“Lñ¦¦)Jã(Þ6ÂƒÓŠc(ô\r±0¦<¨ÑÚñŒ£’€9CL„8 B@ËñsZÀ-°È ‹\r#C¾PŽmèçŠ’°Âï¯£„Ñ5\$NÒx»¾hÔì‹ÏôÓ@A\0¦(‰ŒR87é\0Ê3¡Ð:ƒ€æáxïM…ÃÈ6Ç¨\\”ŒáxÆ9…êËø7M£xÜ„J€|˜	Üˆ7BàxŒ!ðA\"6(,9¥b´H9¸è¢þC{àóMÃ¢–5µêX(\rãÐÚÒ\rÍê%55½³m´­ëfÁ\rcªÕ¼(“p5Å¢°ÂúÉvŒ\0Ä0¿`Mñ}_‘ý|ßoÚæñ£#¨à2Œ`P©B\\†ž“É2-‚4\$ÀƒË[±b±†^ŒcE²š„2Þ7Ùv5,ôÃ¨Ü5ÃÀÏîd3c\\P5Œ:t4ŽÒ¢-O23z¶84dØDÔX‰°mûø<˜8ƒšLÃ’ç’¢a1:/ÌÑ'Q	».VÞÐ–£¶ÖÅ°N‹sq[Vã{eL…ôç[ÍÊ£ä²•â<Ž‰ÌÑÂ\r3ÇÂ•/(A¾S(€\$-›‰#j\$91b(ñÏä<G‹µÛ3jrœ°ˆ!qüo#ŽÖ;Ð6ZOJŒÏÃ2„7©Xž2P3kåµ¨NÕ~7\rù3tŽk˜A?Nó]š…\0õè?‹ò5%µpÔs`Û392šù)ðÛæyÈ—¡éz”¬PÏeo³íŽ½ß¼öž`v|H%|¾S`a_KÈ\r/)÷¼Ôüp_ëômOÙ<¿ƒLþÞá60ð½§ÇQÁ°3DEBh/^ðk'€€!…0¤p xa”í·º‰Hm0LZ@'„ñ»ù&çÐ1DÔFƒ±À2æQt’¶¦ÛÌ?IŠ“`‚§Õ	Kf°Ç½ÕÊXòV!ÌäþŠƒ¤(­]«Ò¦—Õhn'è‘¯?„XöSúiE‡iî¦ø†}Ei÷|ùkÂW˜Q™J,4DÕç„¾‹#™OH²Åõ”š•RêeM‡u;*TŠ™T*¢yU‚²sªÕ±B¸®•â¾XL¦²`\"Šµ5¤`%BNãxsŽ1ýrâà¯ßë(r¢ô’‚tžÅI+kha}VƒÊA#Ç\01tãH›;EÀûÇ•õÉ´~waªª'ˆ¨¡8ÁŒû™º.ˆ j\r\$¬¼—¹Ž}ÑÚG¢eüø„\n)¯iˆ„ËéýC	Ž|ãBvJ€H\n\0‚€P!ZE¢(*\0¤•¾ ÒDƒRì*ˆF(g¢¬Žr’–²+Ï»ÀP“8¼ÈG.¡5œÑîyÉèM¦ôùx (!ÙÐ9ô8¬ò’ó8LÙE<Op ‰U9šN‰¬1NÖ>Â º\n\\K¥|†§üªàÙ1êx r®D‘ZsžÈ+¾Tª^ÉA¾\r”g2Ìßr ‡ò’À§”Pá\n<)…G&˜ë·OOu¾rPö«!e\$Mæô«ƒ0iáÔáˆÕjXòÔh‘Fµb‚ˆ!B‡	„”“•`Ú\\Ìz#„x*¾C}G*Q³~­)±Æ\$8=ÄÞ•’©¶A4‡¦Pw‰­S-d¤Õ“ÕëJÓâh{SÒ-{ÔÏ-Þ½´‡¦X’˜S5	×Ø›¯0Â°³S-TÆ Ä‰©2Ê²çdíßGÔ—Ù‘&\$—”®¬ð‰°rdéƒÃ5žbÈ„às2,Ÿ:ÖýRÑy³L«ê§E'aƒ›0§»Ù|TßŽrÆq'EÔcfúßÒ¢K¿ñý=^µÏ¤Å.Œ¿´[l®ªÃK¨:1F¨âÙ£ÔBÝ)¡„¢e<¼Ã2+az^eì]Â£ª0†0 ”:xêè&¥üÅ„ü…Tò[ÃÆw%óA\"Ëèsr”•’Óø‘«Ðz¦uqæ“°È¸™ëÎHµŽ4ñ‚z\$ˆãO\"`´ j»o±fL\\Öš0QÍ»ÄÚð\nÓˆÃ’0géWkŽ´­V»K	ÄÖøPDÛiŒdm,hsq²EÉ5²(›ðÌÌšáÏ„Ê„œìRáñÛ‹å-Ò‚†B#,=`€ …@¨BH*õ¸“\n'y\rap%a4ó©†Ëøz]Kü•õÿÚk`fYõÄÀóÂø@k`ï¨š¶ØÿDÚj9Ë††EÒöp=OpNn=¢Ú“t	}m°óqxSâO3×bÛÖ·å´_7Ë!\$ÞSÅ9eˆœ¿ãÎgÍHÏ74«p/þx“œü2fV3ô¢‚ªÍâ´•¯þ«Å«?ã\\Ç£DÇÑ×›[m—=Œ†È£Ù8g_=|ó=.ÃËâDJã±7h¯QRQšy07¼!ò?aÙAH·«X'xrEyÔ'Š)OJU“W3éòÌºÉU+®¢©âò¤Ûá””wãïuüîx¡Ñ7 Å˜rjÞ½L”÷ÞÕš³Ûý_¹GÚ`tºJ1)Hç¸â|XnŒ@v7­Éü.%Þoù	¿¾™{JN›²ðÅ’C2ý#Jˆ÷×ùåCíCpO>¶š6Ÿkè½0É ÖçéÎ?¯èTãÈÿ‰+þk£úÉjÜ*ü+êÄè’\\ãDÉ¼7ˆø½¦Dd†LÖkFedFrïÞZLb7¢  à¤[ È4‚„«àÈ'p(ÛaZíÐº¨’\"pH\r…Ô	He„LÓ¢²Š.BŠ/ð4¬faàà\rH+/<a&`@\r¶Àeà0Nn\$ÄÆì¢ý¬_Ç6ý-¾r¬Nüª \rEnü¤Lp©	¯ìŽp\0ýŒVý°o\0@¦Ñoú#Pž G6\râ§\rO¶‰LÇ‚ybpÐæéPÞ%`´ bt=úC\n P¬<ârMb<éø[ŽJéëþçãé‹Xÿ¯ï°·ËÙäëþÚq\rÑ0ú®{ñ:y‘>oÎ íö»«¾;íl¯¶ýÏà4±c\rj8‘oñwkÃÎCN'üÕ\0Þ¥.ü7ÆÄ}…ØÑ0€šˆtfP&!Z(ãø†FÆÅØ…F²#Åò¨â2^¡zËðš™¬&É–:åGÁ€ÜÓÑœÙÌ¦lJLqÜe²øË¥-inq ¼æÊþZÔL¾\r,fÓ\r-ñVúæ{ðÚÆ%¹#+¯ÿàÜX°êÜE¾ÒÍ´Û‰	Ð+\rÏó%)~¡1oÒ\n­·&2WòCÐp-\\\$‰­%GK\0{(2p1pþ8‹Œð¦\$x	b*Í·ÅÄÃdÐP<æÀC£‘Kò7\n*KqIÑ4¯Óq,ÒvËÒR~\r®fc›!§È‘H]Lttã{.fhÇ2JÇªÏ+ÅÔ¿cB>1¾/Æ I Ö(#’Y0Ð@óšÛ-°ý32³!ðÏ--C.äß1¢y.²öÇ„Ý2“J9Ðu#R[#‘taÄIó1ñ.1Â=Òˆ5Æ N-‚J³]2Oô×-…\"Îq63|×S\$6ÒàÔBý8„«7Rø5Ó¤KPF²`#/\0\n¤6ÜÊŸ²Ã#¤²h“Á8Î—63¼Ü¤;6“›\$o^\r	â¦bã-Q*\\Q20þDü=\nš©àë*á…n½,…ˆ3þŠ4UÍ\0çRðh?â5AcG@qY@­¤ÈÂV	b2€#Ð_æÆ…D¦;´£#?ç¦:¦ˆäŽ\0Úå4E\"„4Ns®{B*\r”UFƒJé®wEÎ¢»e¤\r€V;Â†i§º›eÝbˆ{%¨Jªd¤0{®F1Dôª™FF\$ˆ’Df¡ e\0ª\n€Œ p%tPºA´[Ñ#AmMCbò}N“NOÁGÎMMË\n¢B*\"î’ÇjeçRýeÕ9ç1€ô/íúF O”1`–#n/ÄBƒfT´©r\$Ãô{±ô@5&1 è*e¤^Åà¼dV5vñ«Š\$l£Ì|ðÕc!DÞFÇ±ÑU®ýFÏi\"s\"ÜÆOôÎPhæÄþÂÌDuŽýu’íÇ´(€à&¥è^ÐsY…<pqYõƒ§¦X<¢„ÒTé[ÐÒN5Lg,Y1ý\0¬ä\$FJA†P\$pÎ¢ˆ‘|¶Â…_­Gâ²`à¬'I‚BC1`Àòø¢Œ2\"\\o¿+€‚#ÎÝ\\ÃÐDZO±+‡1TÃÜ4ŠÕêÃ˜ÃJ)¤p¡ŒLº¬¿YŒ\$Y•©ZË¤J“I1é\n^Ã²èNh!Ç€";break;case"da":$f="E9‡QÌÒk5™NCðP”\\33AAD³©¸ÜeAá\"©ÀØo0™#cI°\\\n&˜MpciÔÚ :IM’¤ŽJs:0×#‘”ØsŒB„S™\nNF’™MÂ,¬Ó8…P£FY8€0Œ†cA¨Øn8‚Ž†óh(Þr4™Í&ã	°I7éS	Š|l…IÊFS%¦o7l51Ór¥œ°‹È(‰6˜n7ˆôé13š/”)‰°@a:0˜ì\n•º]—ƒtœŽe²ëåæó8€Íg:`ð¢	íöåh¸‚¶B\r¤gºÐ›°•ÀÛ)Þ0Å3Ëh\n!Ž¦~Çkjv¥-3Še,Ã’k\$SøV¢‰G¤Òä˜)ÎNS:On&^ïn:#‚þ'%ÎxäÇ4{ˆÚ¦##°µ°8œ2Žƒ´\"5¹«\$(´BbžšÀâ˜ò¨,¢šð@îËü9-ƒ°Ü‰éÏê0¨ëŠµÁÂ‚È¢ãsB­Qxx0„Bz3¡ÐËŽ˜t…ã¼¬\$#jÖ¼¬ã8^¥KãÂj7 ÃxÜ„J |\$¨ó`¥à^0‡Êæ9ã Ñ¦Pê ˜£&©8¬Â\r¨ÉB²ž‚¿#¨Ö:°9†C4ˆÀì4Œ£¸KÓ-J|	ÃËBØ\"àP®0Å‹XÎ9¡£ @1TÃ(ÖU¢kX	cz>‹?‚¤þW£kŸ!U‹ø‚:¬aà1§¶;\"£0Â:ì¶Ž¯åSQ PŒŠÒcLÌè62•kƒu\\\niÓ¸4Ë8æ²3Iû¦Ü/ö°Ø‘>èÓ-0Â¢šœ\rÎ‘BC\$2<N\rÇÔC`Z9Œl•áA…£ZÉ ƒ}>B®Ñ{eOÓ#KEŽ‘¼sPeHÀæ„² PžêÂˆ.h0ÁhÅ>¹Ø(-Úðµ/ó`á~@â*W¥ŽL6nËb VY—?‚ …xhTualÀâÈÞ‚Y. Ì3b*¤tÚŽ°p¨7ÁR\0òŽLƒ¨Æ1¾£˜Íl\"Ö9…‰€å¹Œ#8Âµ¸Êe-\rÖ`ÊaJN*ŒãÍþ´´\"¦)ÁjÆ„©ah@×ÝÎ:•Y6ã•Ž“‰Ž+Î<\rXòÆ‰8¨42I[l³£ˆ2â#'…p#Ìƒ\$H\$ÉrjˆÙ\nØ˜®3”èûï74‚¦ ;n\\.ÍEÖ»ïÆÐÇˆË“¥*€åŽÆ#,gœ¨^òuð…Á—%Z²lžŠSJ©],¥°ä’ê_Lá•1¤Ê™ÓHsMi´¼-\"õ“©sO/ÅÝ‰Lù¡äé•³”êŒ’p{ÎR:Ô\r3-®Á³&)YÉvÆhÏ†2b™\0w&JÌŒBwRsÕ‘çD¹»·–ög›ñKˆIè˜CÀæºHÂÐ3i4–ÓìaË›mSg­—gÈ‰\"n\$œ£.fÁ\0P	@Æ Ó\n((€¥îKÅ1û<EÈ“„4ÌEáò®O €ê†–ŒK’²†	ÝG†àÞhKiåñÉ¹W.\\›ê;0'\"7Joßa*%„¸Ï¬ƒ<‰òí(¸ŒôPÌÍë9tKÉØ>e^hOyo\"!å±(î\$´1tñUG“Ðâ·O f:Ä½à¼2ž‹˜c#ê=(ðàá[Q)wA@'…0¨@‘´}–Ä*\\·jÙo6°¦'C-)†¬¡KÈÚNÉéì)a¥;?\0ÜI:•4h¥sY’#„xF¢æNâ‚	€´ô»º0T\n,Œ¦Ö˜F'¼ÒI\09\"Š¸–ŒH9Bà3™@½Ú‰\n]á<'\0ª A\n›SÐˆB`E¨hÁ_¤f‹Â‚¬‹¢ð™=–ñm;•\\S ÂK2Y5\\A±SJJÇYHºÁ¨ö€§(åôùk93ò€j\nb/‚\"jíTjˆQUÕ 3fphZ½v?7·€æxŽ`VU‘v½Z¥„–ïh'j<’#”tŽÑá;6²äú%÷\r¶t¢×JÄX\n`Ä¬Ü´ÅÞ©w:¤=É›\\r«KLë\nÝ'ô1gr¥EÓÅoU’›Sª5N)ëpjŒ\"%eý˜TxÁËøK\$¬0&Œ1J[®êÁ\$¡˜£mLKå3¦«´szƒeì¸ü–“~ÐÑü)HMôµ¡‚öÖÅ—\\EœÈ˜`¤³ 3\r4qá£V[aš b;Ë(*@‚Â@ ™ôèú™óK2app†qqPÔg¨#©>¡Â#Ø¬A\0/*ÊàÞ²­Õ‘ŠÆ1„²Ú¬›múj €'„·2Œ‘—™M‡\"í@NFb™&›“ò>(XÐRå\\®Iã1scË‡†ò„hàdÉM«Q·œ²îL	`» QœrV^ÏdN0&oxwV ÏÒ>HW_ÑÔV>ØûÌÎiQGT­—ð®C,Er¯ÚÐ—	\r±%^Œ8K×Q‹‹s^¢TÛk‡Ë9¶Dè²Ïü@dÉü¡´‹ªrcÐ¥\$ûbÎ àË\n€Ù–”(¯j#¶·3ð¥íjü…6Ñª5‘÷	™mÃn¶é\röe[-·U@Pm’åŸU°õX°¦Eô¿„KŠˆeQj!¦”³ÀUa1à¥ÿp§´÷‚ßßjq—µK+ÁÜ»‚ì°t\0€ªd‡#\0¡„ÈAJ¤©ìõ¬n•g^ÙÎÈörÔ’«\r¶—95¢§×F|Ð9vë2Û·šØ®]Æì\0SgoÓcíþ“Òö4¤è|s¥\0ÃÓ\rf6- ìõ›õÏì:f{ÈÞdÌÛ€õô·Ë²çdìÙD„Ôr·×À2_-Ç·¶Ozïû°ñ®µ¹©Î¾+Ë¿î­ÙÇ/ÿ®ˆâÏ[ÎÇªnÖÎÜÜðUÒsë—®ä³¨g¾M)s»îë2'‹ÌÅ¼Ç\"\rÎâµr\nY\râÕ*\$õ;™ßLg˜:*:kÅwß/-çgÊŽôÛ+×{h‚¾äWQNõŽ¡®¯Xæ[µG}^£Ð¼\r€T«jêá.´O«¾•éÄœ\$a?ÑázÊ™°·óÐ-ÔìéI?»µ6r\røG#ðá%à\r…˜a¤PQ¢ø6Å°ìjPì[díÇ¶ðf/L!¯þP0ì‚ñïòe#Jo`Ü\\¤ÌeB:«/…*?ü40IÄ_é:Æð bzBöR†¢Xeà)£ÀLàûn©þÁð~\rp‚ý)úðî8ÿB	ˆÃcÄÈ¶E†åÐˆ°„@P>ÿNÿOE\nÃC ¨¾«ïÖ¶PÔ*.\n½\rãôþïÃpD#ú¾Âÿö¿à¨ŽïÌ>ŒnEPÖ °ÛÐàþ.¶\$ñ°’Ý¦c4ÁÐ2?€Ž‘Ðj‘Â’i\r#ÀØgâäÇT±ÈÐ±å˜ÙLûæòÍàÍP”	e~ÇÆe¢Ü1c\0ÃÇ…Pˆ¬¨ïÎÏ±~îÑ‚ï+\0cò\r€V\rcÄ\rl¦£Ê†ô/¨@Î64ÃZÒ-Æ†C<õ0 €ª\n€Œ<’JF%\\\$ì ÌHú`lVÜÌúî‚„*JL§/ÈÊÊMòQ0ôÛcYcB|¡eÎ@ãz×ãú6²7àZb1 u(CˆJ\"ÃPõú>èî?‡9Ž,ä¤î@ÊPQ’>9bþ_\"0÷Œ4(ÝÍÄ=¢‚ +*¯ˆÐcÊsÒ&û&m0¬”ºëtE’båàË&†<)'_(OÕò](.3(’hÝbb2+ Ú-ÎŸÔ;ëªVâ¦Šä#&*¦ÀšÞl*FÎJ.&âÆ-.N¦\njðt\$+,'@ìÁ¸fòª-¢žYBØ¬ŠX¶JØÀÀÊ›âz@ñu&ÃÒ}IZžë°³TÄa)¡##Æ4\nÌÔ–ˆüAÂ.\r@";break;case"de":$f="S4›Œ‚”@s4˜ÍSü%ÌÐpQ ß\n6L†Sp€ìoŽ‘'C)¤@f2š\r†s)Î0a–…À¢i„ði6˜M‚ddêb’\$RCIœäÃ[0ÓðcIÌè œÈS:–y7§a”ót\$Ðt™ˆCˆÈf4†ãÈ(Øe†‰ç*,t\n%ÉMÐb¡„Äe6[æ@¢”Âr¿šd†àQfa¯&7‹Ôªn9°Ô‡CÑ–g/ÑÁ¯* )aRA`€êm+G;æ=DYÐë:¦ÖŽQÌùÂK\n†c\n|j÷']ä²C‚ÿ‡ÄâÁ\\¾<,å:ô\rÙ¨U;IzÈd£¾g#‡7%ÿ_,äaäa#‡\\ç„ÎÂ1J*Ž£nªªÅ.2:¨ºÏÛ8âP:®¦ŽŽž—\r	f-;¨ãL:;L(Üþ3£’63 0²ù½bÐÂ•=j^ç pã\0<e ä	Ã+8éCX#Œ£xÛ.ƒ(&B‘ŠFŽCÜ5 ƒËÌ6»h`ì¸ÄQ\"â(#˜æ;ãéÉãt£)ÉcxÎ€SÅ2LÈ;Úï1àÂÐ¸c0z+ã à9‡Ax^;Ñr46 (`]2Œáz9IZá¢	#hà·ÈïˆxŒ!ò 9„8é c Þ×6ˆ £&\$Š¤ÒÝŽ³59C ä:·£««)3ª+Ö++C¸@Í NH¾¯í½–RY®üx2Ž¨b…4Žiô\nì:º7ãšˆCÊH„·EÔ–½‰ÒIgÁ+ÄPŽŒ8 ¿ƒxZ\$Ênð\nÔƒG )éBœ·²l¸Ab¦(ò@Ïz4¤X‚3¨Ã(Î‘ãÛ”:¹e¢­J*åd@RüóXÈõŽÍÍÉgŒ´¨Ùf%—Þ/‰â¬A|ŒKz1ÊNÝf‰w¼¤2\rùvj’á²xÓ41s\\©f@®SœÚv®¼…ìcÌÛ±Œ¾µ©ÈÔµrU:8L°ªõˆ£Æé38O] ÀhÛ2I´k„¥!‚·¯Œ V õ•ó¶­ è\n7ŒÃ0ÙF¦bÅ#ˆÛ-7C²µÀŽC0Þ•ƒ}b&MÈZ+lÙ\"ƒß”îèë@–„\n ‰¨øƒ\rÈ¸Ðž )ÈØ=\"=Ó ÈgUÖuÈ7a7ÝŸjäwÔAÞwÞ‡árž'v„LFÅ„jè\rÞ’f!ŠbŒ o4Çr\"Q_+»6.P#&PÚHÊ&Vç%lö^BˆLs®|ÀCüOK«c¥x™…CD”ÕCª:ªä€†p@C\"Œ/aÈÖ†2@B( OIð2§å4Á>j¹.EF©LùŠfË”2²°Ã,'Ä 7ÖRùá{?†íüÁÔ H•A5<ÁÈ§\$ÆÝ^)N7qDÀDè¨î!ØhO©ý@¨5\n¡ÔJ‹Q¡ÉG‡%\"FÔ¢–d*eM·5@G³ëˆê˜Ð\"ƒj>U”Ö£7ˆqƒ‘9dE<Üª“ðBÌU>.ÈÄ²NdN¨P	@…2Z¥ÌÂ©W* Þ!WLVÈ9z„¤,Ý†4*HˆihEüIˆT‘ÈaÇPƒ²@Ç+Ã4µðLVÐåâÝHà€1œ7D…IÐs&eåF‚\0ŠŽ‘Š!‡øÒœNœÙ[2“–ž¨SŒ‰œ~’ªVNyÒu'aDÆ’žGÃ”'tOì¹}Z¯w¡¥Ó0ÀÊ@ÛØtU5ú†ø,`CyÒ„ÎQx…Id/‹®„2¯ðÝ1Ù0aÊ’nô¡>( ³T^NáÈF‹ÇU\n,±x_Ã’.œ™;˜ƒ`h)€™…r8û4ŽV4ô3zRWM[#°Â-¢XmiO4Eþ*´rTVŠQ¤‘¦ÌƒJéÔLÂ€O\naP°ât\$éF\rå)Ü˜<›íXd#”r’RÁ\0o‡)n?XêâwÈ#”t@‚«'Tñ¡ËM¥åaShYH\rÌ‰ük\\UL¯­Zb­ Œ¡yÄfÍžm[6¸9YGŠ§›­‰&aD0ÎÅâb0ØÀÚbä\0U\n …@‹uÊE	ï/#UÃ\nGG—¦¬¼DÀ}ÕSfIlñ%ðá/ÙhH &äô™0'ìl½oÞ{7ƒâ|Ùkjpç>“ÈÕ³Ypæ;¬+7\"0A`p©«Äåt)ækP³˜\$âïŒêbsg™‚pÒ_±0S_&ùs;J’ÈU8:Tê¤Å	øgñÓk‘S¯µÈÛbõP™ ¬€B\rÔ#7ág›lMcJEqA¬¸!bWÚ¹%Ý]Þsà| £cm©î°ðAƒpy3&§S¹³:@å¸w`‹'*­Þ˜²Å:\0œRØZè\n\nµ%ÞŸà8\nb±1K›sÌÒ'a¢ý‡[úß‹£.!SP’Ã«§®ž2-V'š)–¶’blœä°1ÕÍdÉ#má¼þ(Ó9Ú¦¶6˜lý?4K‰&»¡P „0ŒO6fìáÑÔ.C…¢÷,”–úˆÐSinz®“”üyb~]n™ÅØ@÷ašAëì1nZS‡‰aéŽAÐÖîµ¸·j¾s¼îJ¼A·Ä=2;ï~ï¹¼ŒïwÎeNB:ÓClšjJ„´ô!¸­—ÜÐíÂ7ïÂwÒfzÃÞDÄ^Ô\"8ey\\=óÂùVa|¥')n A‹û43­¦ÚŠ3˜Éx5‰m”CH_«9\n^Hø™°[†–‹VFÒâ­¤\$T\\)&ÃÜðÆRMP‘‚Ã\rÆŠó˜Àœ°hÛÑqÇ˜ËôS“(y¾bÙ¶À‚´Ž¹ˆÈ]Kp*‰­q€)c\rnÏ\r…¼K\\+xDŽnÐôƒ<9ÜÉa¦þ´¼ËÙÀç'Ïeb\rèsxeò\\çÏ´oPàœ¿ónúÔ”wld«‘F°F_ØAaAÒ‹6—|9½èVüX“\\–>YŠd'¯ÙÞÙRaþc!\\m¹h]K=^Ð,ä…Eêrú˜ 2ú›×z°RS:>@žz3¿ãSN#õ¾¶%#âòŒ8þO^©-’ÿ%\0Oèü¨@¬4\ngþoõ&vïƒV3ð\0lK°//Uo&Ì*ºÓÃÖ\nMxB¢÷4åpß‡Žé¯*àþàN(&@{ïQAxáZÞ#6â0bâhÞÒÆÚ¹Â0Ó#h'o^þÏÿ€ÛÂU	#Îr¹ŠÓ£	0¨Ùb&`¢[#¤h\r 0\0æ¦# Û\nB:#ã`âÞ9¢BM èA)r #ZxˆLCž™‹7àÙ\r0Ö\0@ü`ðBb²ék|±`@O§‚±¹§é\r°¶<â°‘\$!ŸM4ÑçNh‡\0IM&Ò¯Ð¼ãBÓ­>1…¥”õZ¬5±^þŒ0ôŽªY0ºöquŒLØŠÖÑw	Œ5@Ï‘a±d&q‘Qm\0¾1®g*8õm±‰ê_\$Ì>6@”¢ä”¿çî‡%øçnpƒê£\rmwïOÑŒ&pmÑã1c‘é©Ë\n¹f,¿\rYÀ Å\n.î°b’Ç¸1’\n\rìîî^#eP\nC\"`Öcï€û…Ì•Í¢#€õ¨¤ñp*K2Bf±wQz3àË%2GoÃ%Òa e­\$³%R&üÏ‘p&ñˆKýry&Ã(²vÔ¥µ	lÐþèK)C«&P¬óÒ¡%p3)âŠÔÒŒYò«\"dlPR‚)­ŠKÒ£R›	¤ºAòÏ™RË-’­â*L\"‘ßÑ¨§CÖ\nàÒ@¥~Š…ÎÇÒ\rÊÎUÍ²,\rß0’ •ïïœgZe§àÊÎ½\$Î§®Ø;Gà&ø4Âw.B\0†WÀØ`–sr4aäf0£°ðcbx‹:\$‰ÄB'(BPúU\0ª\n€Œ p4«\$BÐò0müð£9®ŒéNU1p|Að¨#³’o? î§ób:¯l\$íºê\"TÜÃ­5,¦úfL0ÏNÊAÎ†³+Ú#­bJƒr6]<çè«Se#Ò\\BÜGÀô^i\"ŽP\\#«x=`˜#D”H‰´:hÖÌûb:ô\":ŠBàN PWÃÂiH(JôÐÞlÂwä öÔò:\r`Þ-ClüÂ”Hþ²Ò)àPCTmž²+î'SF£±i#çl)‚;DCØC¯t÷‚öÃbŒË\"–Ð‚6–±ä•„w&î+Ì630~I@¬?\0ê5âåG%Ê*z'D¬Ì\n2350ÔI'ÖIt&4”*WàÝC\0ÊýÆ\0‹„\n2ÏòÁk(CPXô<Ó€ÊÀF›E£'DE£¦Sæ’tŽÔ%h#ƒI+à/b";break;case"el":$f="ÎJ³•ìô=ÎZˆ &rÍœ¿g¡Yè{=;	EÃ30€æ\ng%!åè‚F¯’3–,åÌ™i”¬`Ìôd’L½•I¥s…«9e'…A×ó¨›='‡‹¤\nH|™xÎVÃeH56Ï@TÐ‘:ºhÎ§Ïg;B¥=\\EPTD\r‘d‡.g2©MF2AÙV2iì¢q+–‰Nd*S:™d™[h÷Ú²ÒG%ˆÖÊÊ..YJ¥#!˜Ðj6Ž2Ö>h\n¬QQ34dÎ%Y_Èìý\\RkÉ_®šU¬[\n•ÉOWÕx¤:ñXÈ +˜\\­g´©+¶[JæÞyžó\"ŠÝô‚Eb“w1uXK;rÒÊàh›ÔÞs3ŠD6%ü±œ®…ï`þY”J¶F((zlÜ¦&sÒÂ’/¡œ´•Ð2®‰/%ºA¶[ï7°œ[¤ÏJXë¦	ÃÄ‘®KÚº‘¸mëŠ•!iBdABpT20Œ:º%±#š†ºq\\¾5)ªÂ”¢*@I¡‰âªÀ\$Ð¤·‘¬6ï>Îr¸™Ï¼Žgfyª/.JŒ®?Š@PEˆ¢WK¤rC«…º¹)ï”¹/ª£ö§Jª\"½\0*®b×§¥ÒªÊ;\nšÖÁ0¬:Ø·1Š\"¬²ŒTHÂ“JD†±©fy%³)2ª°‘¢‹’Ó: I.²ÅPž[¥1to&KÒ»¼˜%o<Ó¤(e­¨|¶Þ½‹àä\$Ú=*ñœQÓÖ…h§¹6K>ª{˜‚ ïÅ¤š¬oiœÙÔv²@M:õÖÚD\\“;ï5d³®zZ„jRÇ7³1œN+éÄé\r¤×íþ«ÌÁàÂ\rÊ3¡Ð:ƒ€æáxï…ÃÈ6#pÊ9Ãxä3…ã(Ý–¦\\9#~^0Að’6Ž`Ê6åÃ xŒ!ð@Á\0è4\rã @:\rá\0ê9Œ¡\0¦(‰ƒNdß²K‘v³Ï\"\\‘±Öíð•LêãêŸ¾ºü{l×:ø¾RQ9FÍKâŸ@[r-¹¢¯œ+»¡pä¿ÁÖÉ:³DÉêçÍF|²é\nãä7d£:>éÃó™<àAÏfHý¦ªÁºýLRZ¯¥jN	®¾¹65;\"ÿ¯U*Ø†Upß´ïmê³¯\$hrž¨§2ƒºH».@Qõ›(LŒV”7¶”²\\mJšólBp)lûÔ½û\$ª¨¥®Žå|È]öSBÍÔŠæ¤\rmSc`p»JD¼>Ï\"”]Já;- g&†üE‘¸/*Tê7—†JEb¿=‹ì€GÒôûW	„‚®Räñ a2B©A»óÚ›«ƒ~L g/\"B£aƒ‚@N¼RŽƒVÃéoëkŸgîõÏ|>BñêºòÝœ6†P=×àYQ,[åÐçžÇ¥NV‹Éj\"E‚*D¢A{pæî%æ½‰ëe,¯!}\0 ˆ—äO/Dáf¾}^lÈ	#ªBÒŠà!ñ_Ÿò,ˆñ8`î»cæAdŒp…Ç\0¬“´6ô\",IJOGÓ˜±‚Ï7yºU(… [Ù’-€»áõ4¬D6!`Á×‘m!è<#X€KÎ“¤¥Z:¢Ë(–‰:%2˜×J“¬Þˆ¬®2rÀûK\"©&dš\"Òá¸ éx´,À'²a™ˆ×æ1†,¨hÐUŸú“`¨|!…0¤£zÔ?d1.§·tä‰¡\\[šu4ÝH*Å’DŽ\$ö¬Ãš¥ ¨n\raÌfTÔ™ nà€ ²6JÉåÀcfÌÐ22p@Ã˜ƒbŒà9‚ |°aŽe¡´S\n%Ñl‡T¹•œŠeÃçJî%.%ê“-&á¢ô6y’1O²)\$Å‘v)÷÷\0	2ì=‹º„ˆ%çN‹b¬]Œ±¶:ÇÃ»!¥Ì™”2¦XË™ƒ2\rÌÑ›úx êJEiØú—%H~ê+FwQÍVÊÑé!RD§º5\"lƒ¡)W¢âò}°q\náÜ+'fÎHÃt“yÄ*V0ûDW‘\r1¯›. ®#†á¨ŒÓ<Öõ/J<¨au\r›\0îC`ltmT82zLšN!™™\"<Cc¡Ì9†`ëtƒ`oì–ç5 ÐÓîA-\06%MCuC!°9˜SfmeQ&“„a™3ò¢—Yt)êÙ'ô ˆUº\")9?±lWÔÜÑP’7(œ @P\0 Á–Æx\nCˆG*ø•–“¸^X8·)A\r›2k–æZ{QÈ4‡k C8eiÁÁ•JHi n\ráÐ_»Òò\\ ©d•µù ‰‰%k³¡Û¾Gö,L(¥2GpŠw\nŸ\n‰qZ	Œ•¢¹1Ÿ‰bŒîíUWÔB­Zö=w“&ƒ2­VE‹áØù‡_	%Ž‚’†¿E¤^ƒ5ˆÄ,òQ4*&šR–Wº`PhM4³ÁgÈ£ù—QýQ-|”ìÀ™ÛëÐ‘Âråp@xS\n‘¼Nx*Ø’^x¶Iá1çbI›yý—ï“S hd\"Qú>Æ—T–ÕüïbÚQ„‚2(žh¹šDñ¾(‹E¤mº&Hd:Çõe‰AC„Y ª@‚¦\"ªˆçq>™àÌ\n—Úi@&Æ¶ßüXZ¸ßì³©l¦âAÚ¹+áX©•Ñ¨LÔ7`‘\"a•9&)Š¼N¤Ñœ³–wI_r#È†uHX\"eSŒä(y«ôåƒ9r/xÕ\"L¶)öÕ\$ÕÖZEÛøµ§ŸÊ‘ÜZQVV¡diPá]ÃÇ¥?Ý¤šÒL3pÒ°µ d¡)´é}}¦ðÂ&ÅhØ6€™ˆ”c•~ß…ÓÕëCH¤aDú† ºðx¸W¢YVˆx^µÈ.×Ê‹a¢ýý*DWißHvòœŸR÷5|¬N2s¸°s^öÂ~êŠ¯RÁ:B^sŽ„¦!Q4­•Âƒ«1½.öDþÉ%ÉB×ˆ1‚5)€ug°\rZ‹tÜ}Ä\"(*”ñ§¹œvöÀöz^i¢4gf\$+Ô3Sß­½;Ç¼^#2Ï‡r.LwÉî¤¢TPÕÿuè[Båm¦fx{­²<ÿ†ÜÖ^øå¤^¢PÀ¯°…æè‡Cê‡ˆhø£Ð&a\$`Vˆ¾ J(è\0pnÎÄÿÌ&øÎ°‘ˆÂ(­.üìØâdH^Ï.}kE…>{äXõÐ@!hXë,ä&Pbw(šÛ‹JÎÉtéÀa€ZDœ\"©Ðˆ|ú\"Úýœçî ãu\$qÄ~†^¨äÊï*ŒÈŽ*L]\r˜T  ¨\n€‚`\0â¦N\r+ÆÉ¦\$”É€æ àÈ€äf@È0¥¨K-Úè©,„TW0N|Dà@#&œÀã´2gCì<µ(†QÃ‰	>¡l<‡ Åî 7‚Lð!4œ‰¨-­¾Ã±B˜q(GB(ži“Kñ.eÏ ZÄ1a¬Ú;LßPNñ†£³ÊÜJƒÀRlRËX4Ë<mË[ªž	Ð E*Ñfâ\ntQ¨\$qrÂ‘vÑH™@ìâÛ‘7bsÑo¢¡Q‰‘zá¬	IjTÄÐV/.kH^	Ú*qÓŽjDFø8ñ8áíàŒê¼•\$r…KbôNé>-\"úÓ‚é ÌÍM22­|ƒjÁÐX†Ì[çPF1œ!‚†˜ŽðÎÁ\$®¹ÀÊHéŠÌäÒšÒ[RH2MR5¯\\@kt‚ƒ,T,¦›l¬‡q¢ÀrR2!‡Æ>¥ó(\$säˆìÄAG ‰ˆ,Ö·¥~VBÌþ‹qþˆl8Kdô\"òVÂ¾K¨6UÉqä¯)ÆÞÅ„yòœñb¨òç/\$Xriy%`(°&-2ø²üüÇ!0#î˜‘Ž/#ð(óð\r…\0cÓ2ñ1¯“ãy2ÈÖì^Ô\"kBóC@+30E…1Ï,Œè5=/®†\\ª4'\$f-É<y®¨@IL¬P¶é¼ynF\0ˆ@Þ0çØVpy4Âíî²“Î.äžþD—6î|æ·:p6äõQèÅb‘	é(c\"„5/‡>uÌNXPÌtåÂ”F,®®-@S;ÆÌ[.dïò]0;1*Žô	0«=7…6³.Oð¥í60ÂGÄ-A%@“Ùƒí=ô!/àQ93o/sT}”F‡åÍ6ÀóiCNAEh–=â·4¯íF4Rƒ²mÆ©`?Ï¬‘ñä!LËqP\$o[B‹ 1#b!FéHK_H‘q1Ä7”’£T–'´›/‚wIñ!E’s«n,Gcô3”Q3ôUMMR¯HMóI4ÅAGTéFtíÑ×MdnâŒôlt-FAFO(ÇQ&è\$ â³ÃîVä>ßÄõ\"š›TD‘¦DdŠ@t\$ÍZˆÍA>bª.ÉSñžß²‡#Ñžø°|µ&ÒíBçTÑ•9M„pµ±™(ˆÎ³òÕNõ\nØíi¦Îþb¢ÛOÇPôÜU¯«5³G?zˆn>kí:0j/0oW.‚‚2äî&ømµ/C³¨±Ô3Gt€ì†ÖÖ2îJ´\rNsmJuÍ\0/B´^žô1>î\$U_ÃÿF÷_FåPBÎ¶h= FJÒôñTwa´7oOÄ+]–B6b¢*JÛQUû6ubhs:ë6A-Bû–d¨Ò\$Ö[dR€ûŠ¾/â¸·ç¦A¶y©·\"ÏVPíœ³õÐ—H@5RpÅ‹x‚ó\\´ª*´¯aõëbUH£\n]Tsdö¯J“ekN%EÅ½6DWkÕîu”qÓ¬\$Î(ˆVEÑ/e+iet\n]ÄY-³]öËBö\nó‘Žz¶ãohËo´`Á’ñonE¤ÀrMc#zÎ¶ÎNä+uU<ndÊ©@þ£\"£‚çDÖ#D4%sIœ÷;oöÈˆÕ]¶¾.•¸“÷L\"W<³¶éOöÑcÖÕcHvìI¥ué›6WgqÖò÷Ó'¡t·€9†õRn³_^”åjÕïy‚gró5xvÌ:7Ym7j†VÛz¦êH×uW‹y£ç|Q0Ý\$¥D·¡D÷¥w­}D5763¶7PÓ~\"c}w?{ývèqmw½'rZ²8ˆP××÷r¹<aWNlüÖmybM‚4ã}×E˜.L…­=wë=³O€Ay…Ï„)zöd×·cÊÕ\$ió~÷n\$¤Ë«^Öþ&DàKöœ`O˜›tÛ:ÇØV2¸ t·#4Ÿ\$r%qbUÂ™ˆÑÙ‰WLq¼óóg‰Ç²Sê€¸LÇD*Š•]Ð2xŠ¡QÙ,ÏÆ™R4ÃqÜ*SKï×(±Sñ‰Ž2èýqã/ª.Q@O`†`Ø`Æ\r€Ò`Ö¤ø³e?–hO¶·ã!„t<±Ãò<”Ï'2RUZ8/âDGå­m§eWx\n ¨ÀZ”‘ C&ßâ2t2™Ã£·3\"|“(†bv0¥êÑCÅB\\D1Ømðpéç£]3X@£Ó˜I:¨\\Z„ Ry¥¤²Õ‰¤ZÈíëMvÉÐÓ‰¾–‚N¬Û›ø³œ\$L.\"æß¹1]m˜Üââ.€xê_‘À!\\5àC\$–YœÊYïžë)v\$Ñ.>øµ”Ž’ã â+¡P&Ür5eS®Á¢+	2o#˜OS9¢q¢•m‡,#Sr2ðLúÄhPe”õÒœÌ—·˜zJT:N‰e#9#z3k§SÎØGß§×®[z…LK§s/šL4'âz §¼ˆXi§:›Zº¡§ä<G3ƒ^5Ñ<Ø‚%gÆ?\r/ifÈ^ú(@q\n2:U5°×¤ä(ó~ésú­‚Ž:ÔƒÚ*×ºï0Ã…MšöâBÍ®¶E²q]òÆ-2ËxÖQÀP2¿‹ä§ ²JEL«íH9ð5-ž<úAzÖø[’|íozK0–£ó¡×ŽïÏŠ{Y¦Û\\ñ\r¨2ë\n·swb-Ä]\0%bŸ+˜Ô^ýŸ5àª‚ÓµòÌlå\$NÚç£cSr";break;case"es":$f="Â_‘NgF„@s2™Î§#xü%ÌÐpQ8Þ 2œÄyÌÒb6D“lpät0œ£Á¤Æh4âàQY(6˜Xk¹¶\nx’EÌ’)tÂe	Nd)¤\nˆr—Ìbæè¹–2Í\0¡€Äd3\rFÃqÀän4›¡U@Q¼äi3ÚL&È­V®t2›„‰„ç4&›Ì†“1¤Ç)Lç(N\"-»ÞDËŒMçQ Âv‘U#vó±¦BgŒÞâçSÃx½Ì#WÉÐŽu”ëŽ@­¾æR <ˆfóqÒÓ¸•prƒqß¼än£3t\"O¿B7›À(§Ÿ´™æ¦É%ËvIÁ›ç ¢©ÏP·Ùûp°@u„}ÍÆ@6/Ì‚ðê.#R¥)¯ÊŠ©8â¬4«	 †0¨oØ*\r(â4¡°«Cœ\$É[î9¹**a—ChÊËB0Ê—¿ŽÐ· P„óDÂ“”Þ¯PÊ:F[‰‚P9Lèø¿Ãü‘?Ít—\$\nq[Jç7olJçˆn\$'§q¨…'¿²ƒ^ŽB`Þ¸Îƒ|•8n(å01¨xþ\r`Ì„C@è:˜t…ã½BƒjÓ…ËpÎ¯4€ñ£Î ^)Að’’¤1SŠã|)AT:Fc#U¤B˜£\"¯	 ­7 ôßÎ0ÒçI(ì¾ä²Ã¨Æ:!q«Á°¬:TÒ v3Â0Íûi‰Ã¨Ê£ÇL¬€çŠéJÐµI-T1+Àq\"ñ\$K£`ê6ÂÐÂ8K´òP·¹âHÜ1±—².0Ž²Z|P¸Î\"¯˜ê6\0ì¹ÚÕë,ÄÃ­÷ÈËÅ±°ýèâ0cÒa–skœæ¤HDj'ŽP«¡ŽcòÁ»ƒ,Òò»³RÔ4Ø•Sü¼Rnx‚1äY\$ÛŠ‰¸Âe,<ÛzŒ.j/W	€PÛ_NmÜ™W¶E¢•LoÌ£3É=¡e)¬õˆlc~ŒíC+Ön)ÌËtÌ›¦\n\r#L„À²E6“^é¨ñÂ1hËiip\0'lS6ö\"I¨çºÆ¬¤aÛ4Î%)Þ3Ï&3	EzÊŒäy,.7§º‹ƒ‹Dš\"29ŒØ[ÿ5­#›í 8#Î0­.¥IUQCv2…˜Rš\nƒxÖÉb˜¤#:ƒ²\nò9Áp@+ZÃf–£sJßˆëû²L©`Ì·\r¸ZS¦’ª=£>K•m\n?“ˆ@0ÅI@Io@ÏàÖFŸy*?„ÈòQYöN\$x¡’¤îgSÒ|)@ˆ2s^xU¢~®±üpÈ°ŸáöD'Ì™,øGÏâ\$8H\0Ð7w”µÉšI/Åà•üÃ¹nUEX8“ôO,%>'å\0 ”\"†ê\"¨°ä£C’R%YJ1….¦\\;…QªUNªUY9zd†‡VNXÉÅ&Œ 1\"2½ÌëK4Ìñþ¤\0FˆB•c&`*‚ˆ°ØÀ æ˜–GR6ŠàJ*UA„3CÂ°™swéô¦ÉÏA±e!…(ŽwIs3<Ï¸^_»®	Ç…‹ÃýÐ°c¤(€ AÃ{ˆ5Äh RR!0aÌŽ†˜„Ž#‘©U‡üiÎQ-ÁÐ!\0@Uis}!ÜåD´üÈ¸yä\\1ÃD¡!äÉ-'9Å†JhxfF×÷úÔN1®yü’KbDaÉ+êÁÉEP:÷*…‡Å€/bD‚\0PI\"aäÍŸÕw7Ã{\r!4ØÍãÜHò!¶ÅV2J•A’¤t‘*‰½A4\n<)…GÖJ)9#ÈP‹˜¶¢PÞò:„áèÃ¢\"pN‰à _ë½šÏê==Ž3ã?ÉÄÂ¤æÑY*¤3|á5îJ|ˆ¸¨þI• €#IQÉ	\$ñ²•§VW^“¸Jðä~ÒAÃ@6„™BT\n¶8\$… ‚ŒMA<)+.]Chb1ÞÅ.ô,E­\r£?Á@”UNCIÄ.,ôðàÈ2H1FPÄKg¬0W¶ý¥†ÔsÉ±å?fí°Îú~ú§™n«á\$ô6äŸPe<&>Â2BÑÁ¿¹­Ý)&‡x›ÍØI	f·y¬çŠH\nÏÍÆ±¢JàVErÄ½ uXŸ\"_{B¦ëÕi^Å«—ÕŠØ§sŽê\r÷ü¥\0¤tŒc1q!¾ÅºÔÚi~;Á¤=3eêYÞ»H¼¼CÇrŒCtmgð´½¡B÷!ÈM5è®T«i²iC(wJÍf¡|B†9¦6e’oÒK“6Ô·š„ÚÂi9ù9¯±»xœ't¹°èÔ\"!|œÒÃ·f4•L¼ÏQ\rØE\rÖ,‘P¸àÍNñsWhÔ#?Îßdû<§q4S@qS@Dl‹Ñ·©Î¾HT\n!„€@ÜKy©t4‚‘Ç	9I¬õ¢„°2†¤^ÀUÁÄDŒ1®€^V×Cš2Á½sª­d¶×fªauRê{ðO¶±pÌ–†lYQp	K§W] íLõA®Ø:Ûaë‹±Ðù41æ¥\rúã¯v„x[á£‡éUT²#ù[÷Ñ·KcÑm’º7ayÝÄkxlýäF§¥ÓÞÄ×8T‹CL˜oî\n½G†¶¾xha±ß‡Ýpæg‰{×ñÌŒŸã¬•Ëq‰*¡2”¬®ÏŒäX0\"ðS~yRo„¥·îbýÉHÆ¢7f‰’ ç‡%%Uu%¹„ŒÉ{¾{»8œµ¤`“BÙseVí—-ÓÔ¶#WkÐšõ…¶©]ê+¿çÒWŒ\rsÐÄ*™gäþÓ‘»2üÁ÷RÔZ+œ€ÞGjé,Ýß7Ó†MÊGñ¿«h’+µ„œÃ^{È|[—i#ºÚ¬êJ|“FÈeÏ¢\$Œ“”´ÒÃV¸’¢HD3Î2‹!ÄØrÓÀPúYÛ=6ƒ»]W#sì/U?}¾ñ·§Ôc\n¥©„ÓÞÞ©MÜþ%é÷³­ü7,æ;=ÜÝ8É¹?ÖÝôÜ¾3ùŸd&”\0NMÞËÕzó—m'Ždö©ÚóÝîì­u«ÇåØŸ[™×ØÌÀCÌ6ýý¬ºô3âDÿƒøëO¸íð†°øïœ	„´¥à@#ü-Âà2C‚fŒ4B†Ž¢ô:ÇÚTÄ jâöôãíp.èŒ?Gþ¯@|¤€\$Iqð0ËC€DOê\"äôEmô•,!Ã HÐR'\nØ€\0ÜBOöRdV^.ÖJ(îËFºûƒvÍg†NY,†HÐ\ní¥¢íìˆ×tùÐ¾úÏÑ‡Yp´&­Ioü÷hrÐÍûnÝ\rðÖ®Ç0¸màÑÌ7ðöIj2-pE¢Ò^‡ø1\"XÜêÐGã~ŽEm\0¾”Ðm\r¯ºo±\$0e0\rjtÐ1'q*îOºË†Ðw&.óQL7ëÞÐQEÎ¢F,±ú‡±AC·…äçïæîÇÂ%TÚzAÐÂíä«†/%­på«©n|Ôñ‹§WMöBïOÍÓpÝ1©eç1È9ìÊ™ŽhK¼‡1ÒÍñÙ°»ÌÍcã‘Å#ñí\nf9\n AŒÐä\$0nEçãžÑä©ÌD‰Ñ.¹!¤·(r	ü\r,`\"äcåöðCÎ\$±&7eÑ¢2ä¥tý²G~ºòN¡ë8ƒ]\$IbP.†òDˆhÅ©(ÛfÖ¢VnM#Rzý’\\d€\r€V£˜ìDQz>,Þ#œGÒ&€ŒoåL?‘ÇŠ\n ¨ÀZÊ8c-BhØE´ýBH˜R-N¦›®\"Û\"ê)	´#Æ˜uk¾·–ªÅ§\n Ì,,»N\$òf­D²8ÃÈfDD/,ènñ&âr¦mÇöN	H­’\\\n\nM„jE(+b­F®µC^H€ÞBƒÂL2Ù¬!BC6lB#H\n îPaÓ\n»¬TíŒ€!‚ô—¦“fÂ(‹7NÊ—´íüíF™6] Ê2I‚8ÅÄ¨î	p8%˜Häl?Ð¼«\n/S‚W®ø¶/b¦|½SÌ¶sÐnïRÉ‡,‡Ëp?â>1“-dÐé`ê]ëj¨ô¦?s*câJ!„œ7dtÍîû7.v\rëˆªD¾oo<‡»8£wÑŠ·L¬5Âj/K´í…ü:†B¨€	\0@š	 t\n`¦";break;case"et":$f="K0œÄóa”È 5šMÆC)°~\n‹†faÌF0šM†‘\ry9›&!¤Û\n2ˆIIÙ†µ“cf±p(ša5œæ3#t¤ÍœÎ§S‘Ö%9¦±ˆÔpË‚šN‡S\$ÔX\nFC1 Ôl7AGHñ Ò\n7œ&xTŒØ\n*LPÚ|ž ¨Ôê³jÂ\n)šNfS™Òÿ9àÍf\\U}:¤“RÉ¼ê 4NÒ“q¾Uj;FŒ¦| €éž:œ/ÇIIÒÍÃ ³RœË7…Ãí°˜a¨Ã½a©˜±¶†t“áp­Æ÷Aßš¸'#<ž{ËÐ›Œà¢]§†îa½È	×ÀP™MÐ.òÊt¼FL°¾öìAH¥Ð7§SüÊœ°M`ÊµI¨¨ÿ°£HÈò(L3|²ˆðÅBpê6ŒKR‚ƒ;ŠààŒ£³œ„!©ÂÑBÚ0Ž@P¬—ŽCX@'£ î´aH#Œ£xÚñ‹Rþ&@0 ‚…Çïê“\rã{OŠp7 hÂß\rÉ2ÎôRjß#Œ’JF‹	ƒzØŠ°L%8-ã¬ƒÇèjøÐ9£0z\r è8aÐ^Žô(\\’:Ð\\´Œá{çG\r`Ü\rãp^)ð’6Ž,~7à^0‡ÏºµÃzÓ„\n2R)Š2#XšŠÉxÆL+¬*àªMû\n¢jšˆ³‰«ë~É\$ƒ+à\nÂHŠ+ÇV*¨ß¶(j9_Ž¶\n†µR æß¡#Ô2B¼Y,»H°Jƒ¿ªu„hè³ŠÏ¨¸#ÈðàîGÔû\rBÍVÌØø(J#çB\$ò0Ž¸8@É\rƒ­Èî²H»Õ`Ò”¬)\"*TH'Ž‰ÐÉ\rRT–0Ln1lÊ{Š€P 4#’ÿ§7šT4cZŒ¸4q†#b#cL¹ ¨¨ÆÆ0ˆZ(:hS¶7Wä3ˆ0kR-o»xŸ©£rÿi/Áq1Ikå¦ŠÈ6Í…nL¬õ±m(˜2ÉIÒ*5¼Cha’«]]ÓiXä’B*sÅq›­Z£ikšßµï“!0ŽñèXÎ²¬¼X”ã0Ì§©¬Ë3¥Å Øß.kŠÆ5m&:Œc9ŒØŠñ3!C˜XÓ]ÈÂ3£/ZûÎSÌ2…˜RÚ\rð˜Ú0ªa\0†)ŠB7Ž8=/ZW°Í&&´¼›v4ÖŽf™x”J:ZÉë\n£@Ù’r1iU¤èí\0‚˜I@rxáJ“¢u3	á=)€æðdR¯q«*%HmøiI§­J¶£FzŠ£ã|¯¶>¢†ûÓA‰¤Ô›˜TJˆsFî,PðÉÐE;ADöŸSúPj;¨xOC’‹:Š9KCå\$¥´SJqO5B¨Õ)H8«(4*£LgžÛ€H• 7¶OU 10‰pàLÑ\$ jxçŸÇ¸Ué)!yÂPîFšQs¡Ê\0‡\$~AÃf5@¡;×~ðZPlx‡®CšãLÊH¨aGà€1§‚¨I2dÔ\"•ž^ˆi>aï¤€Ì+i§¼Ñ‘ÃN²£ù\n (Kf}L*3)\\5*Od#VŒæ|4š\ni#³. RäÎŸe&ƒ¼Bq§ô5–”ðÇs˜/dÝ\0=²xK_‘¾!¨9\"\"<AL1zˆg¡Šž¶ž[Ë%'à’(L° \$¤n‘Yg'åÊx,Zd†dºû`:‰‚¸ùÊI4`è|†š…\0žÂ -s±Û§ÒzÈÜ©bSþ}Â·bÊhês)‰’õ®¶åTÄ¨4\0Z`ÖHt2”%§ž³S&£Ñ¿Baœ+\0™\0\r• €#IŠ®#ZœeÑ¬øQd}C§ªŠEÄ½ájrp(‘¥<3ž·\0QÑdŒ¥j–ðž\0U\n …@ŠÈì\0D¡0\"Ød\\½ŒºY\$ìÙJ\$€Z’Km¡ejLÊ¢Ý0GDéRQhœ1î#æ•²Æ@Ï1¿›á†ÖW^Øl/ÅÀõ&þÚ›Û}&©¶@ê_e¡‹bVtïÌhLˆã˜o«uÛ2tœÐPK¬–Ï;\$ÙÊÄ8áÖy9ÕlÐãSc¡¸*gŽbÒ´°˜s6¤Ùh/iH0	¤”É¢Ø^¯É\n¬Z€¯Š÷0±p.KY˜ô¹&rœzrØ‚ÈD8w_Ùà\nod˜½Ðæà-Àa†r\\]AÍeè¹[3¼[ÂI@-´òC	Êº!°™öŸg*}mÖío,zØ-g©/^lØàœÐˆ8(H%¬Ò\$u‘IVM™=…@¤B8G¡I5AxN`k­nÈ5[Ò.û³6»fZ,<G’C‡Fa+Pœš:¸ˆqÉ]cØ•¥…\n!„€ADåÁ¥töe'SRâa{j‚µ§(a	A4/0ˆp^5( -VïMéÚ¨KßÉ»(Ï6’üÛ>fªAAÖü—°—“‘p2T¡ý94ˆ2Ù&GÀ5«ÃC>dïŽÍWO\r“r¶fÎW³èîm£À‘	9ðK¡Ü‹Â6GmY!\$d•‘ndJg¹„DÛ°”\\|@H¶âQ­-yšîjÐ”ÌÛ¢’j«Ø\0P´x/K<CØ	nãcŒâŽÅÒ1¾b¶Á›S2n2à§Ä%á™E½uƒú*r¬`:‚ý¹N²å-œ®8Å	v¾Ë/n-qùÍË;ÖÇžâû¢ÞÈ?8¹<èãE• 0W?é[)‰I¥UÔ9òÖ³)h]„—}RqiÅ-7çbtùZ‰t8*b—›%Ž‰fÊ.ãzÐ§p*]ã­Ù4^);C‡ ¸ÈRÉÕÐ:[…ôncpß‚ú±èªˆ€ÐJ2:	ÝsA·ßÕ6gCÚïÎ¦??¶7B†÷ÑÜ;ƒéºŸ¨êÒÓÒzô–Üs#ž,¿sñÊŸã÷+oÓó«™Ñ:€SsÍÏâõ[íò~_Äö=0¾ôý}·‹ýÚIÙÓâW­ÞÏºtÖšÛä}W¯ƒñµ·%Ï§Ð¹6ÜEÿ¯\$VêápÏI=„âý_äÈì’ÉÜÿo>fê\0˜8\$ú ZDbtO£6@b¨¨ò.Ä\0†Ép{dF`4[ð4¥eòˆ€xð\":ŽœiHî.HöÄ#ŠËFt–nA¶€£BAMrððV2P,'P0-G¶ýOØ­âÎ0\$úªúä+D[æ&^Ã¶V¥’FešYàRù£àé¢þMÖ%%˜YÅ¡\nÂôKœÅ£°©/m\nr…žpÌZ\0ÏÂrÞô/âù0ä8Ê@ððê}ÏxÏ\"°Ò†…Œ\"°òUÏðGæ>º§(q @PÏŒü\nb®A!jŽãÀ	-IQ8äæ8„WÑ\"mLx0Œäûm’(Àøï[k¸Î«1ôúéÍ¸ûQfúQnöOžqx ÜcŽæ¼FÞç¦éÂ‘Œ„k¨5)QYŒy‡ö0°B_`”\$ƒ±aq¾m1	\"k±Ãï©N Æ£œÈ‡lžFw±_N{ÑÎêñ„mï#BÎrQþ_m6ÉÅæFQÅ¡ ¬· çLéÀ÷ÆÀjDËL¹oiÑ“\"Òeu\rr*ðhºËìÂÌmE\0§\$¶#}ðî×ÃÚJëe\"û¬&¤«%ÑÖ¹p:\r¸	œ,É`\0 &RŒËq°HæÌ¶ërÕ‘–10ÁoF™R”À³â¥q¬»ˆæÊ%×\n°û*ÐÆ	n¬\rÅøó\rzá'¸lïÉ*åÂ\\d×§ã\$NíNš9\"à†H Ø`Ö&e®D¢)j³Cà‘Gž\n ¨ÀZz\rÈ\$£´&§-\"JgÅàÕlDê.´b„´'¨z?®cblU@ÒÀò–ÀÞÎ€þïï¤ö90h¾c2ø\$\"!'\\¦RÙ¢>;pnåÈL¨ô¾¤ð¡RÞº‚HjÌ–K@Uf\"·+hr¬ \rÇâ÷+‰`¯ªy†p¶bë\"6ÿR|õ	ÊŽéqB7<®=ÏùnŠ6CJ3#6^#Ä„€à^bNÄä\r>äFY\r2dnä!Í!åro¤ ¨¸·¼{‹ÖoEr¥.³¯ñâ9C¦†V£úÕB†²`¤×lXtNdt\$Åì,äŽ&PBdÀ–R¤‚ ‚6î¥q¡y<\n‚µÔZ‚ŸoldË^¶%ù>E¹L¢0m!2ƒÐC|1f2Héa&ŠøpÞ	\0@š	 t\n`¦";break;case"fa":$f="ÙB¶ðÂ™²†6Pí…›aTÛF6í„ø(J.™„0SeØSÄ›aQ\n’ª\$6ÔMa+XÄ!(A²„„¡¢Ètí^.§2•[\"S¶•-…\\ŽJ§ƒÒ)Cfh§›!(iª2o	D6›\n¾sRXÄ¨\0Sm`Û˜¬›k6ÚÑ¶µm­›kvÚá¶¹6Ò	¼C!ZáQ˜dJÉŠ°X¬‘+<NCiWÇQ»Mb\"´ÀÄí*Ì5o#™dìv\\¬Â%ZAôüö#—°g+­…¥>m±c‘ùƒ[—ŸPõvræsö\r¦ZUÍÄs³½/ÒêH´r–Âæ%†)˜NÆ“qŸGXU°+)6\r‡ž*«’>n?a ¥&IYd„—ÈcC1È[fâÁê„U6©	Pœ¶H*|¡jÚ®¬¡\$+TÉ¬ÉZU9KIh‡*°sƒ²i	r)MrTX¿3,×¡É‚vW<*¢	41\"Èˆ0ÍâL¥?Ä:¢‰–oñÄèR@ÒÊ‘a\nÒ¤lœp¨ª,h¥²ïªbÅÉ„#®é¼©4¼ŽÁ,òZÂM‘ÛúC³RêË<–1\"K ÒØx0„@ä2ŒÁèD4ƒ à9‡Ax^;ÒpÂ2\r¯`Ê9Ãxä3…ã(ÝP¥D9#}F(að’6Ž`Ê6ÔC xŒ!ô8Vƒ Ð7Œ\0è7„¨æ2„˜¢&\r53•	G¬-?¥sº:C6NâJ†¤,(Ë½îZ­Hnã4Ý3ÍâJÆ¿®À”IÛõ18%z|\nãä7=ƒ:8Ø/­ÒU8ÉËÓ†ûÆ,+Ò\"VÅé£ét·¬IÜº?¤†É}m+‹ImÂpªLÀáIZU‡Â‹‡±±;\$D#¨Yc±¥::€­0¤/³=®©±ò›‚(÷kÎˆ•L\nwD1cîòºúRW¨ÄÒbŽk7[„›´/Ì½dÙl\nT–Z#«º.ÓüìÂ\$ãºÓ­«¹ÝÒynÇ·wž²›ûko¤rçÄd;¹9ªÓøç°ˆ\nÛªzÜó2¬Ûsû«¤9³Î¬L:wÂD·f“8+¼‚P©ZÂ …Åpé†QhåÀPä:\rƒd’”J³þÏ ñµ·ŽKÑµSä50dÂÇ(òS¿mŠ2DF(XúA&Ä_{qíJý‰[{\\¤c’ËÞzº³únªAzìûi›i°÷1Ž|yñ'VðS‘cé\$/­l>×”Â˜RË7†µDý!æhP!Ðà\\ŸÌ›ÈO©°†‹’d×žSD/P/\"J´Ž(¬\$¨­ò @a\rÁ¬9‚\0Ì§–*¨= € ©…4` j©TE6…Pê%V0Dƒ\"ª!Ñ~«urVÐb+Dè Ý¡\$mÊáú!opÿ2¯\";¹›èOÌ\n} /ðÄ€	ÂJNæÑÁôôºŠ%3±AB(e¢”bŽR\nIJu-ƒr›Sª}Pª0Ê©U:©Ujµ‘·'	1‹ÊéÏ:õ¾ð*Z„…@ U¸TÞS\"IN]t\nöJŒb!Ì,¹rf›J8NfbC…C\\U@€;†Ø\0bYÁMÃðä­aÊ˜9°êÃeaÌ3Y°xg=“Qf†…„@s*Ò%(xœ¢àa\rˆuÖ%eG¨Ýœ 6¾RÎ²ô{&‹ ´ZüÂ€H\n‘ËÆ×/žä‚%\0 ¡‚˜VXM]¯õ\$ò€ÕT™š+ö\n\0àƒIëVAœ2¬à§ƒ¤=\r0ô7ðè(ðôõg¦Ø6nREÊÔäÌrŸñI)e4’#ÔtµI™YA¯Ì‚8Hø’žB3P~6 ,¨£™c€C¼ ’FƒÈo €2•ƒQj:Ç\rË_T0@¡ÃˆuU3 Þb\$˜‰êú†9à±ç½††žUƒ\$½³¯L«r?#r¦Kd\${LÊY ÔÆR\rCe’3œf<ZÝp|Ò•Ç”²ÒIÐcä)åq‹·äï\nMŠCxÔ…–¡+f‡Êñ8YA2Õ“eé\"Ð1%4éë`©Fãû;\"l\\ÔFÁþäRG¤\$5>–BX\\âä+¯)4“ä¬g¡y®ªf-šqPø@PO	À€*…\0ˆB EÀ8\"P˜pKGL+mˆ4j˜¥ÒeL(õ Ü~ô¦B9ŠÈw>yÒIZèÌ’Rëèü\nvø°ÂHNtðÊH+Í\\ø,rùS¥­x^«#r¶ãv8z†Ð¦Ìz a›o†ÇÙÜ-<’r”].¢2'&ó–SÁŠ?3´¯vkÈ\"GI+™1lyW“G!¢¸”HunYl%*¬Ž”’oãÎ5‰¹6–}³¹CmR¥Ì_ûø…/ö\0^­&û®dÏßê&Ð˜Í•!zDž4Éñ.Ño0ÌèY#Œd¯c„†ÓÖ¾¬7†1±®òº“ÑªQE×©º¿­opuÎ•:è1—³“¨õáÛ3ø”ªW‹}HŠ%†\$¡DÏ2ô­qÙ­½óÞY–~öµ@¼¹~×¢(Ä›í›ÚO›Ú.viÓÖ8qhf\n!„€AbTØiU!C‚9ƒ…?wu3stù’aa×”‹,^[ 	¦\$l€ñ¤qÄH-å6†6ìCH?ÆHÍFr×™ƒ””‡\"LÏÌ•òKmJòOŽ…ƒr&™ùpäÇã›3æ˜pš|Ã'—olÂ\$æKÎDlº\r’ðôô}HsYÚ˜ç›i¤P~åìMò\$ý¢C…/k‰æºöc¼MlÂˆòãL×¤ìßžG_¹¾UÌÚðí²ãû¬«\\µ·®s´nßZNDZƒ3%§µ¨²Œx5yžNÒÿM¤'T‡¡Öÿ(@¡ã­zÑvœLŸäNSªj›'ÄzHÒMñËž¶/J»Î¹ae©}bÞ’ãY!4dÀ(\"Xàà‡þ‹0h®à4÷ÎdÍ7Ê­	<›k·¥è¯Ëgäyj™ÇM™Å~ÁAÆçÃ÷ÈiKµ‹ö:à¥‹6‚Á\0(ÃÄÜá\"à ;‘Ì?¹t?jÊì¾ÞdØån´sÌŽu°É¯b8#øõÐ\0È0üz¶.†pÍJªNôp,p(8Þ°IoâœõÌÊaj)J>‡>Ýkà+æJ%lé¯6ò'ºÂ‹¶j§«P)ÅÐ^[­Ùi®—g,%ptôm p­¦,D.‡	m¤¿CRn•ˆm\nKòL«÷og° ‚T2Ã¨¶ðND¤ªakî˜‚\"Dä\nùª!/`ãxý´eM¨¿UÂ?­FG®²ûÍ´HÃ\r,,¯[†üÿÑï †ÇØõ§¬4ËjÁ&1áñòMÞÚ1/\nÑ%±>v½ýNù¤ìûðp±XZ¥àt@ÏðñG(D˜¤@£öp˜b¸ëƒˆƒ¦¸í.»¤RÝ‚qM}‘ð?&ú×ÇØ± ¶\"äðänÂíèöQ)#ËÏg­ðK¯®ñm¼CŠ:Ë‚x­aãÊ\rBÿ°LîQ-±òÊ¶c1¬ü¦ý±Í’	oùÑ2jÕg 0&’ °fXÛÇÍòÊm¬€ëßð°òR:È\n»!ÈëToÒFÛñ'òV4Cæ6FŒOQ65íî·è€&îçäh4N’xFñ©!ì¦ÆðäûÎpç(í'/&ddå.Œ}!t¶‰Z>æ\rìÌIðp1çÅ#rDF¡VûÌ^M†¦)ÄÓ­Ò\\r´7ã^€/>ÃŽ\$0’äÎ8xäôÓ	«L¿|îrhz·	¢@Øk,\r Æ\rdÆ¤ øLÒí±~md6\n ¨ÀZè.Í¢çŽ:å+ÞŽvånF1ßÏ}#2Ê„(†\r=qžócò^ñþ&\\@”Í²RÙk²1B)P%\næ3/ð«\$2xŒÿ0¦@µ#ô*ë\\…>01ë6¤ÎÑc.NkÈèV h™”ÑÉvíR2(îºéËÆêærMbÎ[çNõåÝ\rdÌ¾ÄØüë‚õ-k>ŒVûŽ»JE?3äÝ¯ÆIŒøò/ÐÒsæür5AAT8Í7ç_?§6PÖ¶‘1-²f¤z5d@36O¶÷DÞþiÉ¦¤ö\r~\"Mrl©N6ŒBs³¨FÍ¤ã8G\r¦Ô!T(•ØÚ±€iN¨´Ï3HM\rÃµ'aR2e¾%®Æsü8’@aRË¯ò|mâOò=JLZl”„ë|ð¡±°äJæHb¢ù§É&4Õ9làÇg–3€";break;case"fi":$f="O6N†³x€ìa9L#ðP”\\33`¢¡¤Êd7œÎ†ó€ÊiƒÍ&Hé°Ã\$:GNaØÊl4›eðp(¦u:œ&è”²`t:DH´b4o‚Aùà”æBšÅbñ˜Üv?Kš…€¡€Äd3\rFÃqÀät<š\rL5 *Xk:œ§+dìÊnd“©°êj0ÍI§ZA¬Âa\r';e²ó K­jI©Nw}“G¤ø\r,Òk2h«©ØÓ@Æ©(vÃ¥²†a¾p1IõÜÝˆ*mMÛqzaÇM¸C^ÂmÅÊv†Èî;¾˜cšãž„å‡ƒòù¦èðP‘F±¸´ÀK¶u¶ßB“Õ®5å3±8[&0š¶ÇSYÏ’ÙªJ26¥§ŒàÊ…c›f&®n(ÒøÏ“Îôµ#&ž-ÈàÓBpê™P Ò½#›~,û!'mJtî/´‚B8Ê7¦C¢tÄ	ƒª:%ð”¶OÒ4—¬p –%É‚ðö½O\\.˜)²X0ÁMº(‹#l0Üå<’+`2 P–6Iàà<ŽcË\\53D:»‹»#£@ä2ŒÁèD4(€æáxïC…É;îApÞ9ázïI\0Üÿ)xD§ÂHÚ8 )”¾ã|úÄÑÈÐ7ŒŠ\n:º¡\0¦(±Rj+%=b”1t(×:ív2LDŽË`Ö<É.šÛc%-{bÄ\nµ‚÷.GÀP®„\rÉØÎ‰„µjR; MÂ×ÜŒ@¦„-(<ÃPÛÏTJ è-pÃ¨²xèÄ R\0V@ì7UÂ~êB4è5¨‚3ŒóØÏ~\r0”Ïb0Ìüà–9BcòÓÈ\nÜæŒ¨:5*ŠOËp2¿ª\$ÔÓ§˜¨‘TPØÉb	jB\n¾/×úÙ\roL¿*Öb`Z‚^¸@Âƒ±	K˜Û1‚:¢ J@Ã/°ö*qh¸ÚƒÂq.kZæÍ3íw{ŠŒ&„¢Ûœ{Ÿ¶òÏ´KÎPˆ!<îÃƒáv Ù`Hè¥ŒÃ4œ2…ª\"M¶s\0:ÌúŒ±#HÓ­„j™hŒ£‚Ø¦[¨ÔèÑZ/ó¤¶\rÓ„ä ¹jt´#K`Y²©û:œgoAsÑzûè¸/Êd,W>žtZâ=ÓC“Õ´h“Ôö3/Ú1cÏo6=}Ú“ß¼×02øJm[â´^;cå6b´â4©üb˜¤k*%(à@cø=`€6/³@ú™ÛS.äÔ*ÀÐæìžúoYÕ’¢Ùý™G¹£üƒ8 !‘E—7vÊaþgaÈ'€@ž“â~)ÀˆƒnÌƒ:¤TÄÔ\$º¤¾AH8n	}ì>g¼˜ÊÀ&oä7\$°-ANM­•c6gK¹©\$\$Å, ¨\r\r¡Â}OêA¨UÔL,.Ê5G©&T©wS¹M)Æn<BTçÙªÂ@uPÃ0@æ-˜à@šÓhvYGú\"Db6PS‚+ŒÒ,ã˜[ ûé!ˆ“ÀîN` O¤¹(HBHº(Ñ`‰PÆß`sÅöðÎ}%8t\r\rüÒd{gm–2j^ a‡?FíX šiÞáCGÅÿ‚\0 ÷šGìþÍÐPSIš+¥¢žä€…M2	”\0(!º€Ë)ò®‘æFTPÏ,C‚ˆ˜Å‚\"âÉðoä][¿wòs\$c‹ƒÁð2²¦	¨K.ëô»“Ú òˆòÝ\r«4Å¬ÔˆkƒÉ?Gáæ´°AÖ‹#Š š„£8â d	GîÀõ±H³dzðKã[B¨ä£û»eôýSê€—!5yÎ‚¥“’@xS\n€µ^RaH]¤Þn¦Ø×+Æ®Š[-/8v™Òœïpf\r!œœ’&ŽÖŒÌ\$‘8²L¯%©9£­%È”R¨S\0F\n@Ãë{W0„‰QÓüP(é+%¤¼˜’òSCKšüEÎ¯rsÃ	á8P T¬\nÖ@Š-²JËÐQÚD•RY×G(¾ƒ%@¢°_VL\\Ç:ëÍQÕ'.›9àåX)¨„LË'°•È™à?ém¬·Ø¼ÙIy+@\rñ­Ãù5@NJ?ªÝ\\Ð7ÒÖë[d-’ü6“”	ÕA2¢ñ­‚`„¨1¼—%0•DÞœˆüÎC«jC‰ M–'§0Üh›*JNÀ¶aœÝ’pw'²›Ú“hü×š4dP]b0¦h½ïâp->óš\0Ùz¢´XsçF¾½Š²–aŽWÂ‘e¬Ü^Þ‚Hngs•{µ`@Nò™Õ2f&³µæ2óV¹ñˆÓZM	Û\r\$¬ÅÚ\\Æ³ cžÍžã¦Àó\$RNAÄQÍ‘3|˜@R~\$í’V ùÀAµ¶2;R‰lËvÄ*†\0qGÄéö\"„÷A”µ9\$\0ÉCC”ÅYx]6\"«Ax Õà‚~.e[?pKM„¼< GS70oÌ\\.yøNÞfºÕšûbl‡O®·\r&›d÷xÓMõKQæãÃnMW>«×›2¼ÍÃ®Ãbn5PrnSíÌC->&œŽÏÊ½Xr°ëþµ«	“,á2jw’¼Í9¢JN;û³I6Îµ94û'yhVèÌ7ð¾LÈì+…±e/)‡):È9C°Å„ñN,“«Å‡Ã\$ßm­×“‚‚lËºôÓj—òuKºWæªÒÎjþf9;lÜ™¦²VyÄ8Õ¥9ûÈPeaáâ.z*ôô}#Í.Ü_»T©u\nÞÀ'[ê¦äØÞþ¥|Š‹y6Rháš.Ñ“Êˆ/ÇÊù÷yoÀS¢>Dla¢‚‚ƒ“^á‡PCz˜\$ÊÔ0%0½üKî÷ ø%”rÈe2}±¯öÿ1#M:ðÔm!v@ðP†Ê\n°(vãuÛüGlEðHï(¨ÞÇ¥b)+‚N	ôÿ_&»™Aö·–ý9Û½¦;ä>Ë©íZ] a„(Ÿ9Á/;Ø¨É¢©{ÇA­ÖËö`uÙÁ“bmi´ú£ÌÐ_Oï\nøåØß£j¿lÍhÑJM]Ÿäÿc®<Oð'e¢±Úâ.êÿÄ±\0/ôú.èªLºrN ŒÀ}J4F£¢‚ 'ÒÅ©ŒøËúC/FwGyo\0]°,?Ãé'ò+2Ë@DêÌwcâUn|sÂRá\0ÜwcÖ=Eá‡ê\"ÏÿL¾mîÔkÅŽÍã¨ô¥ˆÉlšŒPúï„çL˜É-Öÿkâù0™\n€úNênì\nlœÐÀÂÑìÐ¯\n0Å	ï‘\r\0ÂÐçhöÿƒkêÏ\rG‹ù\rðÇ%ð¦h\"`˜â¦\"jl0Âl.­Ò|¯¾çÂXv ýn¨3p¬öp£M	GC\në¼îPéÅ¢—gbb)­Éö#\".'vÑÈFaæ#ÀàÀ1VªËŽJäæ#OD^@¦f\\Réö/ù\n1z\rq~Àp·¢mÈô?Ã]\r\r¥Ž²± Ò1Ð¼:±«ª\n‘v\$˜GïÒ]åâ\$ƒl­7ùìÔÎcéPÏ¬äE(O\0g¡Š¥¬Ûo‚î¬¬&×ÐB Qà/\0‚ECiBiÜÄcU/±\"\r\"BÈÅ\0±ÄùÌDÒC]íªLàæ\0É/ºJ šMÁl7mr< Ø1ÅÏqU.Q¢ÖÑRÀCü\$±	*2¢˜k­ÂE\$;Ã'£ÆØOÈÚÎ¿|}ˆ¨Ù2”þEÄ[o*)èG@ØcnPJ(­,úË ]¬ƒÎßj}{€ª\nˆ\0\0Z8eX¯CfþcL›Cäý2p×T(2òëŽÔ¼æf‚¾¦«Âl¥\0%ï.CŠk¤ s8Ãî'd5Ð\náú}‚ö5ƒ\\­£*ÚdÊÚ‚d_Ã­bJ{là¬ÓN¬Âð)&~Ï®ààÇ\\-‡¨‰4-Ô6ÊVí'æ“PPºózî±Cl‹7Âü7ÑåÎêì‡’“N*(‡Df“”Ä|éšì\$Ì'Ò¬Å¤/Ì\n\rîöÛm­ffõ\"&óéË=&ja0øjì/Ð1Ëº`ã	àá:‚D_nÝ ç?£rÅ+Æg¤Äè³w%‚Ú»«®5Â6‘0öÐpº«¼×.*c&‘‘¸^ò0Æ€L®º-ETKB>";break;case"fr":$f="ÃE§1iØÞu9ˆfS‘ÐÂi7\n¢‘\0ü%ÌÂ˜(’m8Îg3IˆØeæ™¾IÄcIŒÐi†DÃ‚i6L¦Ä°Ã22@æsY¼2:JeS™\ntL”M&Óƒ‚  ˆPs±†LeCˆÈf4†ãÈ(ìi¤‚¥Æ“<BŽ\n LgSt¢gMæCLÒ7Øj“–?ƒ7Y3™ÔÙ:NŠÐxI¸Na;OB†'„™,f“¤&Bu®›L§K¡†  õØ^ó\rf“Îˆ¦ì­ôç½9¹g!uz¢c7›Ž‘¬Ã'Œíöz\\Î®îÁ‘Éåk§ÚnñóM<ü®ëµÒ3Œ0¾ŒðÜ3» Pªí›+£ª€“µc¬	+£`NÂ%\nJž< LˆÒì¡*¢®¬©Šâ¼¢¹ë@!	†W0¨è¨<Ž\nT >c\nÜBpÞ6ŒLª:\"FÉCÌ4A,¨!/ÃL|\nLàÊ0Ž PŽÉÇlšÄœ'ošŽŠcËža•\rÐ)¡LqÆƒœƒ1JŠ’Ö5Ã˜Ë#µÐ¬*ìÌšÀAÒ#´Æ¦±´6ø0#¤üí«T²Ö!Š\níNaâz42£0z\r\ràà9‡Ax^;ÔpÂ2\r¨‚r—áxÊ7UPÅV’;!xDªÈøà“¾Ã xŒ!ð@ª\rÕÅ§Ãx@„%˜¢&6‘0‚ü©‰ƒ`”ÏÒ;g«R\$\"ž¾ŒèÜNlSÇ+° @;@7i'¬:O¬ƒ(Ø2cc'\\B¸Â9\rÈ€ÎŽ„£ @7Œhèà8\nÝ£¢Þ6Oœ_ÄñÝr‡ÈÂHÜ1³eMrJ¤wA0¬£È³‚º22oÔ1Þ£.A°®ˆŒìæpã\0003ã£=ø\nY•´›1í2X¥ø†\\B ä®YaSŽ\rïœÔûÙ•*»0R2©ðËW0Ëà)Œc37äPrP6]®Dç ä¦TP˜½£¶žèÕo“èÇÝW\"bžŒSª¥j\rÓÉS=ð±d9¦×¸Ãã©ƒŽr¸÷/´\r·¸LåÅŒ–¯ŽŠzï{<÷[%È¢\"GmÌOW+\nŸn@WM;qœtö\"S:¡S’O‚Lû¢Ñ¡¦î¥\r	s^¾0©ÐˆÉ»nÇAé«áÅü,*‹^šŸ²:ÚÁb¼‘Œ#ËUz8uã(%;T:À•(nmÀ¸´àÞùÓ{é|o±ð>÷âüÓSö5fü?¦ú“ÛdÊþ\0Ä¶N‚ o\rj¬0¦‚1ç,¨¤T‚Š÷2¡¸ƒ?d\"VIpm3Ìag6*A’P -5†àÖBC1.Xäÿ‚\0‚©0r~O„’’º¤”ªYY‡0DHnPGý]«Òt™	ƒDaÁ%'§ä™[÷ ÏU¨uÖW`¤5)A¬Þ›‰A­\$d ž¶8ØÇN¬X‹QqL‡E6§Tú¡TpS‡%RªÕjV\n².«R@½˜ò« Aê2«çHR³ÙMë\0000“FÖÛÉD36RF¶©DhLq5gìíš˜nBS”iC\"2Ìºt²Ð9Dän˜­vÄpÁ²FŒñ1\råôÌÌ•O¦*j7D(Ê””þQÃ™ÊUÈiE–Æß^	—\\ÈYÉ¥BB€H\nP8;¥¬AT\"†˜¯˜ÀæHWéˆb¯‰™ÄÖDkq@®É;¢|à¬d7‡pÊ	Ò…ŽÊ\$ð™˜AÓÔ}HðÊ¬ˆK¨m}¤óžJLœ‚2B¦K˜c.Ã¨gW\$Á&0Ò¹Í\$4æ¤ÕÈ\"½\rxy2d(Ý·ƒ*Ý^¹R(„Äù)¨ÛÚ&j5ûœVðk]“ÞuE((ð¦	óæñµ!cª“EK`@Æ­ÒøbTk!\$T‡_	ì+kåLØÁ·HøI¢\0LýÅÏ hªI·©‹[†õFæŒË<\$E,­“ôÊ\0F\n“ìó*ôÞ“Gv¤À¤Õº0äÓ*E'AP”­dÏú`Ie„†6á ×ÀO	À€*…\0ˆB EW(@Š-Ñ^É7ØöÄnÙ)l&¶ÉÊPoZáÿ;¨à'‡\nJµÎn†ôA‚\"’ žø©Vçì˜Kã^JK/¿7ìþ.rœLIC¦?èþ'GN›ãÆ¢ðÐ£—„LVKÃ6)ÝÆÏó²TRµS3³õ§Ê‡WÙ‹ff®Ò¸¬!`ãwØ'aÌ\$–Q-€¾“XÎ‘ÖNÓÛ’\\4½)6âÖ\0:Wä\$»“Ô\$Øç²‹²Ù->(iD *œ\$!Çh2RQ’Š¢L•¶M•³¢ÆµÆN!•|L‚ÓH|1DåÁ†Æ`*^}%xÀ 9‚”Æq!,1îÑW…Ý¥ÁÐô†œ+NÓ˜V@9¸³™’\0S‘ZE(ˆitÆpÈZ'\$«¿Mƒ|fšæ¸ÕNß¶ Ïp“ù¸Ê­¢‹àAõKk|¤Dp³!\"1™òØû…7j–¾Ã‰3\\*b:0ÄHvL\\£ü`ÜË¾Xè=5#}L Aa#.ÖžR—Ù(EG»ª>rƒ‘•7ôÈâÊ®ü¹`@¼o¢b÷+`H3¢Ô˜jÃxlo'¦@jCÔa07äÂx#¿\r¦/,8øÝ7Ç\n3F8þÌ¸—Zoþ\nR¸Úã\r+Z˜-TÅ«©¾8-©ß\"tÂw»vä\\“‡ŽPgxŸ€„r•Ï%ÝC”ô£¥Èùë»k+6_òîí	~Ú[-@&²ZCl¢oìdÂ‚™Éxv—¿–Û_ò9nQÀFD5Ø¶ä“1]\ná”1u~I¦í!MÔÛÇ¡vÃ2ÚMˆ'!›Èè˜£´z»¹žÍ’‹ýâ‘HèHKEï/`»øta\nÜÈÇöUê½üá=Ä\"¦~ÂXdÊ¸'õò‡.{!SÉ}_÷>í\\ÊÇÛð…;‘í¸–vAñòÉù?t§æ<ï¾1ã¸_æ“/±TØá“úˆêî6ÿºœøÞÞLœ“ëkPÔ™vË•Èª` ¾ÎÞz&r6‰î¼+º'«Èÿ'Èý@ÒÆÆø\"h3ˆ@F*%`ÜÓÆbÄ ,kÃpÏÏÈú§†uùïfö¬Jú‚xÅ¬ÆÉþûïh†f-ÇÆ§‹o öÂ0aˆÂ0ioµ®ä+8t'=O~ÄM\0öÌL§)‚‡Ïïp'bQ	§Eæjx0	ú^OZ'©Þ;g á§âîà²¥ ðÂTÐ Ë.°ê(Üå®2æ9*âzÕohÕ«‚\n[¤âƒ©@øë€Õñk\rq!Qq\nP‚)C±ÄZq`æÔ„NÒj£RËŽ„¥¦ÀX&ìœ`éä(¨6€@.j­´Ó°3®»f\"ÃqF/ÊJ:Ï;gV3FZ=-hŸçRî8|dJ:„Oom`Îœ.í Ó0òj\rN×@%||Oª]Ñ»1Í/h‹lM0DÍ°w¥ŽwñÌ'ot-¤\r¨ö1Ý°Ko]¦óo{ðO‡ Ñý!£F;\nmKçÛ±þ>ñêÆR,2r1\"ðrÏ>õŠ\$NE/JaÃ\"·\"ºdªê!DvVïfú°ßr	2ûƒ4Ù²me2kðÒ&îR*tˆ’cjKX[lv;åÀÆ1Â&fq)r7*cØ`’ HÆ&xƒ*m£ú[ƒ&ËÆ7(O Oo*w,‚‰ÈüRÕ,c»,²Ý!o©(òÄ2ØNr®Æb9.MhNp…äc-ÒÑ	p¨'Ð!-Ñ011ºñ	/³\"Ó#1&¤Ömze0±0ð§S.×j+°±.ÒB­vÖ}4Q/(³)²-3óPH£\0Õ@§§4Ri¬ØS`Ú>_ÊFd\nÛ³5ñÜúrBm¸MsU'Ï…S„F­½1“X@?pˆÙ„f0¤¤¸\r–h\"„mý+,xŽ‘_c6nïpàLv lz`qQ(f@ñ“Ô)Óc²1æ†D!Ìì3èwfø’9Ð€éf@ƒ´°sâû1Ó>Ëv,@ØkŒ\r,¼5qyâP±Mæ6ò!bs\nˆïlqNÄî¥­h1c8©ë˜\n€Œ pçðÒåòÜ¶B\rŽ0àÄåG¥>çh/œMêvÏ&h]¬Ô‘ºm2–h&à½àD¢M†~âd@¨HT¨CX8p²&\nÍCfP7tþçdj\"_±®EövCÖ\r‡ªÅì:urOMò@c£:3äl©ã¶õ¢”]Â”Ãñ,C²n¬ODT—Ptªf¤ÀŽiQUG±.€ðµu\$È3áGÏ8ñ\rS1Qu(Bp¤Óä€ã¶T­!>í(ZcÍÂ:h&ˆUfÞ‹þ!5'Ô	†º½fV)PyNÕx½K&0\$ÓÀŠ ëø<ó¢§d²åì|ÂË¦½ÂXB\0Œ@ØKÄÑ¥ÈIŠrÝ/P,`ÜËÃ¢ÀfàÀ«ýCK\n7°uêxês\\ãaÈØÐs,¯B%Èy7¡\"Î6cãØ|æGô\rÀ";break;case"gl":$f="E9jÌÊg:œãðP”\\33AADãy¸@ÃTˆó™¤Äl2ˆ\r&ØÙÈèa9\râ1¤Æh2šaBàQ<A'6˜XkY¶x‘ÊÌ’l¾c\nNFÓIÐÒd•Æ1\0”æBšM¨³	”¬Ýh,Ð@\nFC1 Ôl7AF#‚º\n7œ4uÖ&e7B\rÆƒÞb7˜f„S%6P\n\$› ×£•ÿÃ]EŽFS™ÔÙ'¨M\"‘c¦r5z;däjQ…0˜Î‡[©¤õ(°Àp°% Â\n#Ê˜þ	Ë‡)ƒA`çY•‡'7T8N6âBiÉR¹°hGcKÀáz&ðQ\nòrÇ“;ùTç(^e†·ÈëÉ:àð¼3„ðÒ²CI†Y²J¨æ¬¥‰r¸¤*Ä4¬‰ †0¨mø¨4£oê†–Ê{Z‰[îê\r/ œÌ\rªR8ƒ\nN°„BòßˆNÂQBÊ¡BÀÊ7Å# äa•­ûÔÝ`P§4©Ì”¥5*ƒ*÷D †ŠÈC\n:¾,´ªŽéÊãpÊÙ>\nRs3jP@1¢³;@òŒ(ÐÍŒÁèD4ƒ à9‡Ax^;Ðt(¦LÃ\\¼Œá{G?ì:Š…á¬	)\"AÃ xŒ!ôH1È›ÄNH¦(½M*h)Œ©\0Æ1Ä«êS1EbÚŽ:Èä:¶HK~&ìjŠÜ5-ÐbXÉspÞ7È˜Þú¬4Û1BºQ°2HKSŒCËJÛáÂÒÉ2¸Ø:«è£`T¯N\$ëÓÈÈŒlÝè•Œ#¬ÆŸ*tà\nË«ä’ªc(Í9<•…eZ\"¬xŒüÖ\$#;63Â‘X„ûŒlz*ª Ðjjã0z†9Í®®2Bdˆ¦;âb* 6u: ›¬VÀƒYÀP €d32W8SC,Æ©·l;yHwU‰€PÂ12€V8ê²¶`Óc¥\"¿„é““¯l\rÈâ:Œ²p†Í×»^Úß ’s².ŽLÃEbƒPÕAñ]2’ÞºñÂ1ûxËgéÍþó0Lä’\"Zç»7è6Z·ìû*Ñçìá3(°(Lì#Îh#tY¹£¸ëúïZíj©ÑÁø°X‘S¶¸Â¡\$*ý¨À*µ=\ràH‰Ø\r=—y\0lÛ'qÒÀßiN÷û'„•ø—/³]ãx×âb˜¤#wƒ²6CÁp@\"ßQ[ÈÚU\rrJšV3/#k<Ãy4u¼7ŸrBaH1bÉ¼°†q\0Wy„\rÁ¬þ¿ÂR}ÏX !‘D§vèÈéC%)Õ§„ôU>*ô§>¨P’X@‡XîˆÑòÇÐùÚpÞÒÓ‚ÙÑ¥”¶]M9ØVÂ\$2ÉÃ«î„‰Ý…'¤øŸ”‚PÝCAÃ°R”XrQª=ž©%j¥T»ƒZÏbª\"zF;*Æ¸ô4ÚˆJIK<L¼šû]j¡‰âÅêŒZ¹ª1ÇðšBa\rM’µÜÕÅÌHCJ‚È¥S†ÌiNBÀM¡Ì9†c<g;L¦†‚o#Ïz)Mæl¡©×š:Ò4’H LYù00þÆY|èP	@‚†÷\0(*À¤Ü›Â¦„Ù;#Ä	TÙC:¨‰&¤twI3³?¥|:CPØˆCº;BRÐÀ+@Â„&Š#€„ÃHŠz\"8lš‡aõ\nØT%ÈEü§˜R¼ŠR¤'åéH‡ÓQMCÈSÏ©)_«Ð•e^ðK€5&Ä˜LStRX­a,¸•A¨¼¢K\nrd— ê^(šîE¯D(ð¦I9v,í5#8û‘ÔO6ïÝ²šØiHÙ|5šænH‡cöH]-!¡Š D\r\0–)¦3¡ˆæŸ”QŠè j’¦šJ,N‰à ~F#I˜uè¹&`ÔÌª³&”KÊò0ØÓFPä_RHx\ráà&ó^lŠQ¦	Âw¢åj\nXÁ6!*P‚HZ!Jh„ðœ¨P*[@I°B	áH)Z»[kÂ E	ÚÚ),¢œ]‹ºã¿@ JA!LÅ›”Ðêxp¬¬]ø1ÃêÎë½YkM7‚ô]/Œ¤EÐ½ž@ŠûAlMéÈ½”yÓ‘ŠhwÀì2va©ýqò\nªË–™Ø‚¶Íú+…ÒÜcoo#¢ò¨T£El½5r@’Hs`…*Vb¬•»=¨T¿ƒü€1)*“*ff¡7ØìWx£# ÌfÙaNÊ²É(,Õœ\r–xŠÚ\0¨ãRHT®äí+PÆÿÌ®hš÷’4le[«lnôõ¾Ö“)9”ÜÛ!C~³Bïq (aˆÓ¢KŒåãY¹‹ŠÜï(Ù9{f,€ƒÈÚv`0(PæÓÛ‹ÊUB›½)g›»£¾“=	I˜†–8©Újwˆ)›S†‚3ýoˆå#lAcê+¨i“[;\0ÀT\n–Œ\$ä^1(¥´Î‡	<šr)ö#<IÈj§àrm\"Î¹InKÚ¨'%®’*gLú	fçw¶\rQ°ai á‚à™w/,[ÐÎ©öÊZ†»¯zË—@aN:jH|×ŸíèJ	¢å„?qp{“~E\$ÝÜ+oðÉ‹¸ò¾ý›*üñ'\rÁÌ©êf†ã|¤—^d9[(ëÞÀ’{¶Ù9Q]AÌÂù½I¦„°§(9Xƒ*W+l–™â7ã<“ —{žz	KÄd!ÎÊ”«¦®•áÈ@e‡e\"°“z`mˆ»u†sÖzÅ½×ð¯Àjj¬[kµ&š!8vç¹Ó42&M\"we«Üu&¿y{¶œ–šoLOsX­|—@_a¼Eúq^:ù|h’‘òÍ=]¦3*ÁQ@4èí¥Q’ûBa\n†túbÄII%tä¢˜±d“sZeö„¹Ö°F\rÁŸ)Wûo’Z‘3ýO]èbÊüƒ›Z‚ë]¦\"ÜÎ.¸e¸ÞgÁ¨)Vœ{dÁÄÑôS÷Ì/áÂdry£þÝúp•õý™ëÆw_ú¿•	íŸ}î9|ÄòC6ÿ†ÔÿïÏp3‡0BC'#*pûâ~…­ìx­¸ÝKòÝ­ßîÝ0&FÍïãú“Ð2KCÿoÞMë\$+/°\nþ¯ÑCé…\"±ð\0ýÏÑÐh”\\cD\rï¤²È/-FV…§€‚,2gôTƒ8Wbnù‡v(i?Ä˜­¢,ùÌð~­ô¹O¦ÀŽÐÄ`vÇòO2\rÉì¡	P¬Ð¥±PfÒlE 1/ÄÍ^J,­ƒÒë¾‚Xo(°bY\"Oï	¬Ðý±7OÚYâË¯¼ïÀÊÖòþ‘	‘,‚'Nå\r}ñ6^Mj±F2/x<Ž€uÄ&Ôà‚hä€@äÖ”ºÐÎüÃ\0Þ‡ïà‚øB,2ô…÷‘…q‰îè7'\r{ocb†_qHqj>bzqCqQy…à²ª¼ô&>£>íq\"Êéêy±ŒññÒm‘œ¿Q—1ßqåqC±ã£qIìÄP9\"V)Â7¯\n2ù „¬Ö²ï ãh˜Óbóñ3 I¯\")\"ñ«\0R'\"¦;\rñ \0ˆÓRG‚S\$ò9\"Ã*\n†Ú^1Lv²!\0Iô^Ò0ñ®ý&äK Êk'ˆ 	´&\0ÈÕ(Æñx2¤t>¬ŒÚ#O¨%€Þà\"†)ÃBÛq¸3ƒZ‚ÂÁ*ª6BO¬1åÊx„Æ\$äºyqm,nð_øc®&Tîà_pG-ªBD„\r€VgØišk&à¤v1ÄBAb)\0×ÆØš£pNöÇ'F¶\0¨ÀZœß\"Då¬Ý-ðE3)ŸÅ¤\"â2C)¶\$'4Á8¤O7S)Eb6#°I3p£Üò§ØÓè*“åòDT‘ðÏ‰\$3\rà ¨#~3>(0ôŒCp`	ðÁÓ–cƒÆL€á†vidiCÈì‚ŽøŒ\0ßPë4ˆÅ‹þðÃû<)rJàà@AC<¨<ì¡;ÓÍ5ir»\"œ)A=¯ŠÀ3íŒ FKCÊdpÁÊs?åˆóË¨úë¬L/óA¯±Búù',‰€ô(I°\ré´#æ`è\rºKÎÊ1óðËÃn2 ‚KŒÛ±b!Bé5ÒD2³¸&C<kÊ%EüŽ¯ðÀ«Ò)F¡=cVÕ\$’-Æ:#~\"†x¢çxùæ:B¾\rÀ";break;case"he":$f="×J5Ò\rtè‚×U@ Éºa®•k¥Çà¡(¸ffÁPº‰®œƒª Ð<=¯RÁ”\rtÛ]S€FÒRdœ~žkÉT-tË^q ¦`Òz\0§2nI&”A¨-yZV\r%žÏS ¡`(`1ÆƒQ°Üp9ª'“˜ÜâKµ&cu4ü£ÄQ¸õª š§K*u\rÎ×u—I¯ÐŒ4÷ MHã–©|õ’œBjsŒ¼Â=5–â.ó¤-ËóuF¦}ŠƒD 3‰~G=¬“`1:µFÆ9´kí¨˜)\\÷‰ˆN5ºô½³¤˜Ç%ð¤n’Ëô½(F½SƒóRsxä&!;èV©Q©ÍA¯)öÖ`–ØŽâ!§½Fçq	¼î¸\nÓèô7º®.|—£Ä£¬µ¥pBx´±+Ù®þ îJº,¢ÖÕÂÉÂúÁBÉzÕ #¦ï?KZvœAÍzvñ°o3 (Kš†1p´rúÇŠ®S5éìl½‡ƒ@4C(Ì„C@è:˜t…ã¼´# Ú4Ã(ä\rãÎŒ£tÐ<“Hæ4óPD¥‡Ï+ÚO‡xÂ*HB\r'e@)Š\"`Ó6¼	zž“’µ{šÞÆ©3Šù²h;¶œ!‰\\b—ÓÓü†“&tûí´j\"6èA\$Âñ%ÀP®0ŽCtÀ3£A(Èð!02<Õ¦±‹÷°1b€¦iª‰>¢t4‡HËãpÛG‹\\NòVå%Hšî‚ •¤²\"züÔt[q¹®S¥´k^·Ó	ÃäOÅ©­(€ÛÎ™¯2á#ˆrt†ÕhêL\\‰Ü’Õ	;Hò(õ2¦!)&`±Ó\\Þ5ÕdkÆ‰\\mK«lN<¥±‚7\".6P×ØL2òFiS»o­y-Xµ¢…çŒbÖ†Ú{\"hµ[\r¯ŠqšÒ¹Ä\")¬&dè¡”˜9ƒcž¥nò^…é;dNuÆîÒ—–@žfÉÞÖªÏÎ\$\\…0ij_„“ì#¸ïò ñ×H2kxBÛÒm‡ hbæ¤ZŒn‚o¬J@K®É3 P Éz H°4~²R\"@ž¹±Œm`ó®ã¨—!al»/Ì#–ý±±7…\$ÉrlŸ9ŽaëŠ>È\$ó=…ÈÚ‚ší:pÄ 7Æ¢r¨ÿ;R§<“Å®3_È¶h:v‡RŽ…Jw’d(JR¤­,KC¼¹/LÉ3MPË6MÓ„ä±%1\n\0kŠ7ŽŸ™ädJ9n›”úäM9Ûx¸š—#êçÛÁÃ:yF*&ÜKNÙ'd½z@ÐA\0aaÑÿ\0îC`lŠÄ“(mªì0†dÚíƒ˜uaŒ2‡0æƒ¬2\r¼3¦\\¡Ã@ œŒ†tM‰¦ØÞI1ÊˆóÀS\\DdPA@\$\0@\n\nX)4Ék¯@†œS+VñH7‚\0àƒHv†”3Ã¸ü™C s¦EàÞ!L1\ráÞÆv´’:td™È’òfÏ™Êû`ÎD4ø½ÌI53¯„µ(°\\xÁ‰;k!·®âHŠY†y…·†ö}\\Œ±;E„èíL“``ô–‘ÜH	ÜŸ5Š¼˜6hæŒ`¡ Ë%ƒžB{Y´¿sœ…\0žÂ¤¯#„”‡‰oÌÁk&¢ˆÉ d¦ãžrn:B\0eË“!&=éÉÂ®Ã—)œ*FâL@Ä²B8ýf×˜ŒJ'>‡BMÓN‚Y+º=´%Â<ä`ão™±ÕÒu°ZØa®yŠüš^ó‘j'‘-3ºž+kGÄ™@™&ˆ`M=&ˆÒT‡›DÚÇjÇ.S2näÞdž\$ÐZª™&ÒÔ¨Q\"üÝ5™¦Çê³#”-*³Õ×\$É¡/'¬ÌîN`1À!5Á«åœa¤Šh¨‰B’RÜ2ÓŒZ5ÆÓÖ}lR‚nÃžÂÔG‰[g¤K„µ£R†ZÒYDlæ“×¶èf¤²\"ÖS/š uU°™¹ÜjÎùH‚HÙôbTÉ[‡jÈP7‹€ÛØy=¥Á£0a&ÇNb±‡’ŽçU m)®ì–éTT6‚I™Ë+\"³¬3ÒÁI\0˜`«þ¡Eš„\$áx´¥’Õú°ÊÍÿuë¬Ä±3ºH‚T\n!„„û2ŽÛi'µ!‚oékxˆ9Â‚ð@EÝäG¶²1„‚DA¤@ß\\. Är±Ý“PL'¹ƒ'\r ‡c ¼%Su8e©\"aL2ep•W˜\$›cV@]1õªE¨RÊ\"ðëWúä(¬>å°ìšG\n1! ä2„Ñv{Ø¡ôDÍ	x¸µè	É”er<Ë+=&nµhžàóZ°{­ÁØ­¦ËžGõA(ÅpGEâí0,ìžªìd}E>‹Cš9ÁRªXG4a\r=sÕæÇSÁ’	ƒ©06ûNKøA¨ØrË¼¦©jCˆW=22Vøú7AD´‹Q-?ËTž­s™-@PDA¼8²'¯Ú>+@‰	ìŠØŠ2õ¥ThÅë¥0@n=ÂnT)í•TZ09ƒÛKI` QhPš4É²\n½UÙ&¥&ê›³MÜG/¶ñÕm9«#B¾YË6Öa¨oýáÀwÝReèÃy\rNG8[xn‰µp¦®vöíu#d—<grL´;6ãŠkcóŠî‘/ƒx½ðÝYÆ@hÿ\r_Fþ££%ÌxI'»›Ö~&·\n1¦Ž”.ûòl‹YŸ•òfnæIêùs•½œ¹[#‘Ýi= =kpÜÛÔó–å|'{â×Ã7æ×43\\#­YÚ|™/;;³ŽÛÝRÝIéŸºJ2¨&\r¹j‘	ÎŸ}áóà•#xå8šèßÄ²&±­ŠSÄÏTÌ\\ôÅŽ[™í…¬I¼×ª^cÐp%Frî)Ûô„C[ù=Ãæ|9õUW“2]Ã©w´µŽ)›ß‚9—Í\\~øq…-Æ½òø¿ÓÓnCYÅœë]ï<T‰Žx­øikçBÒOµYÙÞ°ûEa‰.…by9½×ˆ6þ+ð|j3\\þ›ŠÝlÇ†dÍãù}Ÿ\\ß¯\$ /ÊæCu\0EHþ…¸õ&\\T¾RÊÕÀ¬ï2 -kÂÊO¢{ï˜â¨»ð,[ŒàR‡É#–yÍ.õb:çD*;Ð	„V60SÐ`@a¥¸Ô¡‡ŠäxÊeÀ5Æ#ì0TJì-m¬yŽ®'f5ÂZ:´Å(D`öã›	Š”âÖä\np\$ÎT`Á*#g.=è°€ä†@VHM¤HŠP0D‚6ã6ÄF6È\"ZEÜ)ìÚélø>&Þp`@ èÀZ²{iümfˆÅêÌ×¦ê -\\%gömó£ÚÌe|x°°daËÇÃ\$Di˜oQL\$HKŠ3©ÞË\n|ïâh0Å&\$ÆÎ!Â<1\0=O˜@„¯ñf#eÚ“/\"éÊ†ÕÅàþ­Zîéfô	7¦›ïX;ªb`1Œþ”Æ\r”“b¬´ äÜ4ï¼i‘¨3¢ô¶‹â>¥Ô›ÆÞóGîñ€Ö¯@§­ÒfÊÔ@Îì:ëÂt#qj¡J&>¢ÔµlT\\†z åàd®ó…*äÇ-#Í.³ƒ–ÊpÞ”­ûÂkQTG…‹Åêx¤,!0Plâ@=(æyò(lÐÄ @";break;case"hu":$f="B4žŽ†ó˜€Äe7Œ£ðP”\\33\r¬5	ÌÞd8NF0Q8Êm¦C|€Ìe6kiL Ò 0ˆÑCT¤\\\n ÄŒ'ƒLMBl4Áfj¬MRr2X)\no9¡ÍD©±†©:OF“\\Ü@\nFC1 Ôl7AL5å æ\nL”“LtÒn1ÁeJ°Ã7)ž£F³)Î\n!aOL5ÑÊíx‚›L¦sT¢ÃV\r–*DAq2QÇ™¹dÞu'c-LÞ 8'cI³'…ëÎ§!†³!4Pd&é–nM„J•6þA»•«ÁpØ<W>do6N›è¡ÌÂ\næõº\"a«}Åc1Å=]ÜÎ\n*JÎUn\\tó(;‰1º(6?Oàôÿ'ï2`AJ–‚cJ²92¬3ž:)é’h6¢²­« S•µxŒ”5Oëþa–izTVŽªß”#h\"\"‰@ñ##:Ä.è£d·‰9f=7ÀPŽ2¤ªKdï‰Š¶œ7£ ÄŠ+q{95ŒtF6D°„	IC\rJ\rô¦PÊ¬BP«Žˆ\"¯£=A\0äŠFAâb4)0z\r è8aÐ^ŽôH\\0´+º4\rãÎ¡ ð¬Ã˜Ò7ÁxD¦ÂHÚ86Ì“œã}¢JHÐ‹·!\\ÖŠbŒš¬¦â Â9;cbKƒê5¥Lk¾'*ì”‰–i æÌ/nóàŠ/©™gZë¾a“CRB««0\0¯]ÏrÞŒˆ2h:7EÔ¢]—tÎ5€PžÃWÃ…§EÏ&ÊŒãËúˆ#ª6·Êä\\©Ä[ê\"£0Â:¥!\0ì0ƒ¨Ê	m›ÿZ PŒ:ÃXÆ4ÅZp3Œê@Ï¢¸âãg¾³8åWÀ\"1&*@Ü¹àkzò•l ÝtŠ¬PÞ°ùmµ(#ð¥‹XÛ^¹Ù;n(@9ŒcÝVÍ…w±/ S\$3´pvÔäÌ²”¨áZè%²Š»âš¯„\"QE°ÌÛPöö˜ÃJE^ÅïŒÏ*ëü(6M£è3#¨Ú7åUáH¯zZÞ\"Ýyi¯‹ô3ppÃiQ“6æ·ˆ‚Tá\0T;cð“º%,sLÔWmhÞ3Ê›ã¯¤ÚúŠƒ{_„4u•2:Œc\n9ŒØ¤27ò”ÈXŽCÊ`3Œ+¸Aó]Ãjïƒ¡@æ¦æ,*íÂ„¦)É€ô§³€`¸²Ø\"é<¡È˜†êÕO˜ashQÆfkÊ:*äÕ2R„¤U’š\rÁœBƒ“ßjqM0äÑ©O©ü¦ |Is	„j¡UvHÃ\n¦)(d2†¤|ù•6Ç99§RyÐj‡þ öÌÃ˜wR+¤2ºÒR\$†)ñˆ§õ Ô*‡Q!ÝEÂu¤Tš•‹ªaM)Å<¨Ò¥90ñU”ÅZf•'Fó”¢2žÉB¡¶ÄRC(k!A¬>ç®¦Ãr\n!œ¹s²Vd%b%®SŒ|Ù0aÒL\0îmPÄOá™H™%ÒC4VoQëE‡³)ãæ•æhàÓ¼d\0cŒ\$4±€æMÂqw/0a¤\"@“tÑ2}€™óèÍÌáž/n]ò5€H\nQÍs¬\n\nb\nd|›„58B¥YîV&ÄÙ›Snº]t §7ò”Æðw.OÅù»RýŒ°n&	EÌH²vOOût+Fu1£\r7Šº¼¡`d4òPº[YŸ0F:¤MÂI&œDrkŠTógç\0á€âÆƒ™JÁÈ’ÂXÝÌÓøjúyÓÂ\nœW&1i(LB€O\naR‰›àBþVx¶h§\$9ËtêëV]!)+ï±yº©4&\n°ƒŸò¬à¬wó%±+%HÔesA¦+P˜L§ó™ €#IÖØ—I= 2™TBA<ÒÂA\$¹ÉÊ\$Ø£i2aäƒšÃžªAYî\0å´“J…±ó:6¹{/€Þ\n˜e5Ž=³”h¬B­ØHjAé{NÊXã\r‰ÌÎµèEcKdœú\0 ˜ÄXro%\$P;†î[ß“ô¡çjˆÕÖäš\n	OJ.,áRpÞ˜½êu×¡1â~È&¾n1Â†WtŽÀyˆ&ùÌ\0 ¬È‹l¨aˆ·¨1\r ©d­¢Š\\Süé\n\\·˜—”k0ã\"Gö®Ó„Vik[ÌZ-•2Æç²£}ˆxËJ²åv‰ b-t5úÞH–ã]¡<øLÒ€`—I´¡ÜŽ¬’’é­›gñvHå\"æêÍ€+Dï„e\"ÙˆC“Ç¿e·wg\r½Ÿ´\$Ã¤@ÈàB¡²e„høg)9ómÐÍî\$\$3|Ò]['²=¬ËTjå€PR`Åß„YæhƒËqdH‘ B¬,îsˆº.\$ …@¨BHÿ\"›‡ƒNù» 4,ý–y\\Í°k¤-\0èvÆ»y_]ÄX9.ÕÓ¯5ó_R7ZHë2´xÔÑ„-Ïâ‡2ÛüW£{úîRîVT.7_Y}hrÚüÙtKf¸m 6‘K×ûT£ír’…6ÞÅÛÛpl–g³\n¾Î5[D0í=×ö±ÎÝóBia=ó¹—¡ª%Zb¨@Ã MõÞâ7Çc4oÅNúÜ÷Xž äìÃ¹oÈ\\™‹avÎ[*’êrs¬m˜µ}•„¦ø¡ä®–C‘\\A”1;3ÊŠ)Œ‹–0c·—5n¯0¸¦‰6ºì‚Þªæ§WI)#:>p>G(…/SãlO¥àÑ`Á\$®a×)'|¬…¿lIXl5ˆTå.+j–‡sÂ]³»tÆcy©9/kVocŸ·Ý*ÖÌ²ì›v¿é¯ìFÛg(:cü*OË— f8 —ç—Hƒa’YE*œ£Ê‚%D·0†w+:œf­\$ë•ài¸ø.Þ{ŸwnmÝáôÙT §Rï•äŠ­îàŸà“¶‡BNSË­­%îÿíÀ((Å :œ›æ	Åg½n¿ÂÞÿø”eçqˆÖàJ	Oño5ì ¾D•ùOáZ?–YYÌR\n7¬‚ü«àÈOüoèòoúpoô ø8ã&\r0?-•Ž›°Ý-¨à\rÚàM²0\"|Æ×ÁZÐ,ßãÉ-°Þ;`ÏDß­ÔØP06P4‚ŒÐ³È0Íp\0æ°j@\r‰¦n¯‹;q\0¯ì:àäÌ Ü\0Æ“À@ €ô_'0‡*®ê\n/C0ú£)(6Æ‘àÖ{âc	¡RC¡\nI(øì¨%°º´pÀ{ãÆOlü¹gT ÊJ0¨tîÚ@`Ò5£kjalÕÂÞÌPÊñ¢ÀïšuNŽ¶°¢¶í2ÏKòaRYP\$*òñ,½Ð,œ)PŒ‚…‘¨†¿«þÓ„êém!,„þTÇ±/oÂ3íB&í#ña¾;ñsqLuG	b´Œß&6	°Ôlc\$ã*h+\\ùC:B¶íe…QXB±¯ÏBsj%æD‡ïŠðZ@Š\rˆŒ0•ñ{fJ÷ñ‚uq}D|;°ôX+ýG\nËTHƒ”Nã–%ïJ*ìZR'T<ñ8æ¦t¨’\"òO)!²­,µ=!Î‘\"’n´_hÌÈCã\$R!`ôæ²Nú±Ýã¿%¦\$\r8|Îñ²ñÌì#Qbñ¯'h_Lã&òy#Œá(Så¤³„wìzík¨K­,Er*\r(DÂ*ÎJK*HRS\"H(?`æ3q\$Þ„i;£îh,\rãVöFb]Éh;,\0Ê®Îò/íƒ.¬añ/C2¾2úÀ2îˆ“Ý„	m. «ˆ%nÈéj\$]\r‰1\"].êíÎí´]Ó2C6àmƒ3ðKS8ê‚\r€V©ot’…8®f.c#ZG.¦ÀÌ|D&àŒ±)¨#Ð|ê\$\n ¨ÀZ>/.=Î!‹\$sƒÿ0.|åG9Â:™:ey9ì„#Â@\$BH\$nw\"lB^&/F£Á93nÑ\$Ö/vN|í,„¼'énkîÎ:£Æ8&/‡V)B´\n.®ñk¾\"‡&ã°7¤\0`Ã°YáfºË\0¥\"5¤¢I”&=ÂÖÓ\"öˆÀÒ–`Ã¹&¯&+¨0Ãˆº3\$ÌVêÃÈiƒ6“òV”ãât´\\F¢|\"ÎåE”l))!rL8ƒlÍƒV5¢n•‡ÔÉ\n§G©(<q4’U‚Ý1Å†xl`š Í†	ªÔ^¯¢Êæ¢ì†ã?SÏ®_, Æ­	àáIF0 #þ»B?-ÑÒ‰q§-À”5e Ò`ÙExÍã2-a©4d<tr+âuæyPÕ-¬È\"«¼f2<ÀŒ‚²\r²Ü9È\$‰ÎG#:ÖÂÖl,\0à@Ú\r ";break;case"id":$f="A7\"É„Öi7ÁBQpÌÌ 9‚Š†˜¬A8N‚i”Üg:ÇÌæ@€Äe9Ì'1p(„e9˜NRiD¨ç0Çâæ“Iê*70#d@%9¥²ùL¬@tŠA¨P)l´`1ÆƒQ°Üp9Íç3||+6bUµt0ÉÍ’Òœ†¡f)šNf“…×©ÀÌS+Ô´²o:ˆ\r±”@n7ˆ#IØÒl2™æü‰Ôá:cŽ†‹Õ>ã˜ºM±“p*ó«œÅö4Sq¨ëŽ›7hAŸ]ªÖl¨7»Ý÷c'Êöû£»½'¬D…\$•óHò4ç£2éˆ\$îïÃE’ÌN˜“)¬ç¡7^èòÉtÖœs:À¤¶ë¡Ó(³	HóJ8#Ã;Ææ :T‰'03Îáºõ¥ÈC	L\">ïã(ÞŽ¿ËPˆ0ŒË€äß½ã(Ú×%lN(@°;œ€­N»ˆÙ.\0Pš•Ž£\\u\"Ð ä6§(ð c@ä2ŒÁèD4ƒ à9‡Ax^;Ër†6¡	@\\7ŽC8^LcÃà½¬¡xD¤ÂKVÌ7# xŒ!óæŽ­Þ23ªÇ\nbˆ˜4´)h Ë)+@æÐlZ6÷ŽQë×Š¬J¸5l»½J¨Ë‚ä£tB“&C¨+¦Cszˆ„³àÅB9¢XÞ6CðÄˆÖSŠd	#p×%×Ož:CèÒô’`Â:ˆØìóŽ£(C­#@#\$#:ö#<–‘Ûb.2\r(ârºh«HŽ‹ór:Ò-k®¸\"\"‚r5Aª{Úˆ¢hËi¡ËO£`@Ì#éPái¥Bà’Ð\"`1G®jöØ]TµIÑ`U8ôqSš!¨Ò!ÈvPÁ%m.:(2Œ³09ÚSpá0Tvoä™66byjoŽˆ‚U‘C…kY±;Ä¦LpÞ3ËHÜ2¥¢^’Äâ ÞÈÈÔüøŽ£Æ˜c5™ƒã:9…Šxä<¨Inõj8„6ã(P9…)n½¨\"¦)ÊzØˆ\$p@%, Û?6ƒ8@3Lm™È©iC½àÙÙ®pL]|›ó	›ªÞ„É.jã–â1¬«ØÈ”C%É³XæÃ\"Ëc#óœêº&+Wî…4 \\ÏÂ,¢íÉlw¦hÈæ9Žóø2T–2qÝÔ•&IÒ„¥*JÒÀï-uòèå/Ì3Ý2ÌãLÓßM³|TG“’tNÅ!<'¤ø±3!om!6\0KB\"=[&Åš#¤Iº\r!™Ò˜àÂÊeB&]ƒs\$JIOˆÐ“3ðÙ›Cj`ÊÑ·î¡¸h1ÄÄŽ‚\0Æøà\0i<çÐ\"žçòâŒng(¤ø®P 8'K2A\"t\n\n@)‰Hþ\0 †YZ¼ u É™S.fC*|gaÐ›šS FÏ:´ñ¤–„ÜfÊ€&! º’ŒfzŠ¡´ô\"S’!î5R)9eÈOIù9qÇH9ÈC[Ð)´\$ðòb	Ú|ä@@sHMÒXqZ'½Ë‡\$>ë_‹±)ðè †5hÍ%š&j¢xS\n‹è9WFM	‹óqëÁ®UP‹‰HDžd“´–Ê,A¸3’A%O”›M><­\nB\$Óx1/Á– a*ErŸ`#jVÊöh‘sY\$!r²ÒÌXŠ*Û	á8P T *…‚\0ˆB`E¢@('ˆ(Bµ£´|ŒÉT@Jš÷A´Q)– ©G˜Ó44' æQÀÃ&’ð\$'|êf„Ž{‹e.ŸÌóçÌ¹;1tõC4¶6Ë¥ñ.d¤lÁ±Ê¢ˆÑ)22Rº\n€ ¬a‹5ÅÀõ‘¬J'\nTNîÝ\r”÷â|Q)ýéJCÝÑóE„Œ¦šÕeBiuahä=-(¾jÛê,3‚4ÓÃªÑèüy*U\rÂØ„Zl*|2Á”; Å2mbŸW®Ü÷1æ4ÀWÙ®g çL•6¥¬ó9Aº‚\"öY‘‚\\jš—†Ö4-Ò¦fœ¢Ât†‘MiÒt]Ì‘ ¹T4Ö¢4rÏ`b1;‹p*@‚Â@ •L4ÍµÔyžqÐsÎÉŠ%¤DÊ´øÁöT†Q\\_EËQÙhln-èÁßÉˆÚ‘…þ.+ŒÃŠ1vG¤í|B€K[ÑÊa¤Ð9T†¹0©9Âèb÷«ã¼ Òá•ÁÜˆ…RDQŽA6a„}l’7M‡	±;H…C¢3))(()˜æ¢ä\"CzC8XãŸb\"\"Ð\rR`’2ŠùÌ4Ö}èekœƒJ ¹`¦°Ð_‹ª¢uŒÑÍÕB¨ð ©GLê’ÜßóI\\“MR†œì¨Œ¤Ï8|½hSŒœ‚Ã˜{9ÔËBÁt^'aÕKh’å¤s’äb„h–Ò2ß`€Q¶ôqM_ðÂ„ŽðD•ÁÀù¥ìŠò]ë²”ë\rM©!2Ö%¨'jUx@WÞ˜ÏA§J8Õlª‰½£µ5þW‚ƒX¾ø)×Ž¢Ëí…¡*^u%ÛT¸mrvHóQ£Ää‚ÔJ­·t;ÓaÓsU\rÐç´’äØ¸,)²½¼¹6ÉôÞ¬‹{†Ö]7¶éÞZV”’%4knw_R= ÖÝ€Š:®0„ÞàŠøpXK tÛ¹n¢s¡ôãVÓŽ:Î?¼è\$¶Ü›xiýTÚÊ³ŸÖ­Ü#ÍkŠ:©á.’R·¨5Æ\$G³™1ç)R“r;ÏdÂåµ¹Lõ\"mž‡:ƒ%Pr;kAõ/Òý(ð1’IlJ5!Evõ¥MûÊ,÷mÉ¸wxò\rÛ8>ýßõIŸQîäkB-Ôß»ç;x.OÁ<	ï\\ÂÓ`Ëu;áñé&¬Êob‰‡—\niæ!0´a¬Æ&<Ì™š3?/Â[¿ð—>è”±½G®å»½±÷.¶Vß¶2eŽ4¯#íÈúÛ»oÞETN€vD'#è¨Á–RJÏƒä0CèUOg¡;ÚÉI[ºrîáí¿Û÷ÿ…<ìsKê¾Ÿæ&üÚ±®ƒ²=ÿïXöä4Û¿¥£¿§öõø/ü˜ŸØñtEOêTÏ†¸Tä&TÏ5¤`\$C¸þíµ¤\rïöPË´<Óƒ¾ht€Tõ‚î>«ê¥ã’¿Ov‚¯Ê)\$½©î_æôX‚àh ÍBüoH\0Çî*@¥JÁ`†?ÀØilþ¢,„BYçF4FÀOh6n…% Œž4•ˆLnàª\n€Œ p<v…È#ì0âLãéò~pXÊÎx©Æ~GP”Àò¹æ\ne ?Ô,Ã¶<‡ 2kˆ pä.íÀlcÖ\"Ãr\$4UBŠêET%£¤(¦ÂHZ ÃHDà˜\réÒ\r¤À1Æ;\"†:6tlé‹–ìM ãâÄ,†q@„¯®'f”_ÌÏÍãâbjÍ-1RßÓíú\ràà*ˆ\rŒGlËnþ‹ÃèkârpÒ	§“ŠT'K¬9¥ì6¥òÙKKà@%êªÛkø«È>©¥‘x<âü ÎÐ¥êa£ÝP0n¢ë¢Æ,¤;Å‡ JªÝÂ°`\"HÍÊº¯ªÄ€ÈBF€^ÌBI°1(Z>(2\0";break;case"it":$f="S4˜Î§#xü%ÌÂ˜(†a9@L&Ó)¸èo¦Á˜Òl2ˆ\rÆóp‚\"u9˜Í1qp(˜aŒšb†ã™¦I!6˜NsYÌf7ÈXj\0”æB–’c‘éŠH 2ÍNgC,¶Z0Œ†cA¨Øn8‚ŽÇS|\\oˆ™Í&ã€NŒ&(Ü‚ZM7™\r1ã„Išb2“M¾¢s:Û\$Æ“9†ZY7Dƒ	ÚC#\"'j	ž¢ ‹ˆ§!†© 4NzØS¶¯ÛfÊ  1É–³®Ïc0ÚÎx-T«E%¶ šü­¬Î\n\"›&V»ñ3½NwîÔÃ0)µ¤Òln4ÑNtš]¡RÓÚ˜j	iO•Î4AECIÃÒ#ÏCvŒ­£`N:¼ª¢Þ:¢ˆˆ\"4Î\0@´/Â©\nC,#Œ£z(ûº­T€*c*r×°L°äìÁ/Ð cºÐ2AðˆÄ?BŠ·kèôó¿B`Þµ\$£ƒœÑãô&@ä2ŒÁèD4ƒ à9‡Ax^;ËpÂ2\r«[-8^ŠÌãÃÊš¤xD£ÂHÚ8\$	˜èã|õøÐ¼´ÂPŠb‹¬ª%¢³TÞºCÐôð4Ì-Ä-£M˜*c”: kòð½/‰ƒ8©ÓËÊö‰5‹£Ä¿	Ë ìŒ#q4x7Bº ô\rÃ:Œ\0Ä<ª€My_X\nŠ7‰\"Øý¿µ ‡NÕ¤tÐ­cŸhÁò€Â:ƒ @Ù\rƒ«ô)Ö1úH¿ÌMÌôBÎ3ÉìmÖýlú³¬cpãqBxä½YkÒRŠ£H´‚éÁBc3¿4»@òZW˜t¼UJš”Œ#u\$ˆÅ\n&C4Â»m­KPU\r*å¸`U?S¯¨`ÆüÄâŸLfq3gœ§¹RçBƒ6Î°³à´.N€ç£ŽZNl2¦Zê¿gÙcô\"M~x¿8iÖ¿[±[ É\"	Þ3Î”’–ˆ¬#ö7£@òã±ÆÃŒÖàAdÈƒ˜XÐ[˜ÂÆ­aaÌ#tvaJZ*\rãZ*b˜¤#)É-À4ã¡pA­lâ`6&Žf4¼Œs²Â.J†Ñ\rS‹p§î»ºv7ñì Ü5µc2ÐÑ&µÈ@ Ìå¿·/249c''Ê3xæØêØÝ×3Äôú°òe/ÁÿmÁ(äš¦)]ÜeÉÒ©æ„eªÃý'Œœ÷'J”¨•’ÂZKÝ/<T’“ rLÉ 2¦¢*›rnN\r:£Ç´žÊ2}CIý^šräœ2ÞHÁÉ\$#ÂZ		Ã'gœÿ†U^f9‚\$%Ì’³LUOÙù„1›²žÈù.†dÁ;èHUèaÏ¼†VìÞÓ|p±\0:ƒQ\nH™!ZÑ!’ÚzÚRk…ŽdÌ¤ó†EŒ(N0ç|Ÿ\"By |c\n (DÐàÓ‘§“–IHb(\$µg†ä“NrŒ¡¤Î<¯cÁ«5E9o PÞâD„U©XÈæÈÓ ‘Üô—Ôæ\\ðP0DtÊ–ˆfƒãe=E\$…‡“\"LUé#[Ñžš“V“×Ùä#¤6¼8\r*â«“k\$áš‰&üLô¢\rò‘ 7D€O\naQÏ'8@Ò{†š§¤Œ-´í,!1IéVF	JIðgS«ÎY€¦ÆnÉ¢N½/Ãµ|c(6k„`©XÊ½&QâÌ4<CJc!Æ¤æž÷Þ’@Q¹UlH'„à@B€D!P\"¯Ú<(L´·¡è´²R¬¥ÆdˆE“”­R¹aª=~‡ÖaWqjag¤äœ°¦ÑÕ\$M5õ!ÖÔ 7ƒj®0¨A•£‰>¥\\ê5ª³47¯*C^<êB­¯Fo5Yû-:\$TÜÆPÞí‰¨\n\nÄB/H#¤kãÊ´\nÆ\nŒ“ä×Ž˜›Íˆèz—j;ôÐ›’)`\n2í]äØ9,µŸFÒû.eÕq©eè‡ƒ‚;¬!–Äƒ tœK;f„À‘¹ª°ûl7\"*T=D…¾ê½r‰*YµV_Ãqz%L¹S*\rpH	…\ni•%/Ùì\$b´eê†ÉT%rzb0e1„•É“öZLò+¨!¦¡¸xIqk\rq1››7ŒBÝ4ÊÐ#‚rY‚‘‘{è\"™hÑVŒ+O;Èµv…@¨BHˆ™ùe.£´x“'@9IÂ’U^\\Nƒ«Ð^0é‹1«	^–“òÒ­ už‡†tàÆæÂ[Xe¤˜·ÞaÐˆ.-·â¶§†Œ/Æ%˜Èu¡‘;†ä¶5³ìÃk#”÷†YäRy-Xx»*åwZòblOvøë-á¶æTr°u%t¼’»Sû1æW½)…o@îCH{¦‹\$XŒÅé]%2³ d…CC¥^Ij#‡9\"¥jCŒEZÄgÕ ëÄÓ‰¥C\nÊëˆ¦TÅ0œéiÌ-rˆ»¦VAnStÕBœJªÒµ­¡j¡,´êË>C»&Z¾p‚¹òœ#‰®­êª5vÔ—'o§Hm¸¤KgY­”L\"Þ9¥¤QTµ0´µIú®k\$ˆÆX¸€I]S”g¨ƒ\"öš¥«ìh\$@ÝÓý¶H_Žïb[Œ´4[q¶“(±•€þ4{p¬úÉÄÀ.tT¸)Þõj´Æýq°tJ6ªÄD‘ì×ÙU8©¸fúë5dû´ìcì\nmo[Õëæ}yfÙ×\\®Õò~Ëèœ^D÷å&#qE/»âÈ˜‹°hÌvöp	ç—ïŸó¤#Œ²+8=(†'+®Ø »¼·fº«ê“úÏ[à,Ãmuû´îàen|ÉÕB‡gÂ’I¹ŒÛ‘¢¦u1ô/VîFÕ’C\n£·44Ûœb4e~Œ\$9<µðˆ›†hÕ1}=Ùìé\nt»*=/Bé:nÉofì=«kcðßsçb¯!ÄNAëÇy|®Hˆ˜v5CµT›­ÙšåÕ{±ÈÝV¶êè_ãCîøÇÅÐ^ÛjgŒF9•°åçêÏ•ÀÞÑ1/ÞÑPãïq;â3\"–ËSï×>ùk¥óï™cWíî=°»ý2:º¬Î°f&j·Ä…:úÆ þï<³/„ÿ†îþC%8²£@\$ŒE	‚óÃ€âí´\\\"QîDj\r«ÅÅNlìªÿE0°./Ï„8pJYŽ@Ö%l¦@¤E®¸×'Øà¬¦JZ4#J<PbIP2çDðpWðx±DøCwmÑPa	ô\n‹À•oÖÙ¦yÞç¤¼éVú/êæëÌ]ã\0£\nåúJèÖª\n°e\n§Ù\r}-uéÀ	t?\$hþD\\Hë ©è\\­âüXpÍëŽ}âÖlÈ’®ÒÉ\r:‰áQ¡BJ\"âä-Ã@h¢80e¸¯'f<ÄJ¸î†V%¢ÇB”1kãG’>§í†ô&#Òc”\r€V™b½c8å¾-©\\½>T äY/B=Ê¢*e} ª\n€Œ p*\0Ü7&\0ì´ê,jNfÇ,HÄL†šÉkFÇÌ2jL2µ£%Ti+¦»Ä2tí'VÆ¢8mK×1‰)Â˜\"¦#À•ÂZEäˆ/ÑB&CªŸ…zÚIÂgÂ]!CœQ #@¾BÌíÑÐbâH#H4àæ,bË’0ÚS#o\0†â©’D\$23\$£1#ª^?ÒVÛ¨ÜîR^.,åÎ¬Ù\"@5c(ñèri¦7dÂ¶§òô²j\$%G	%ìµ‹9&‚Ü/\rÂ%Æ§jÈ§ªâ0ñ¢jå\"oi8ŠžÈÍÄ‡€êA…ú’Š§€‚-…§‰\n¦ë~›Íò6r@i*Ž\rê’pª‹êÊ©rôiÉ¦‹Ð!ªx\n¼=¨&ÌTŠíÐî	\0t	 š@¦\n`";break;case"ja":$f="åW'Ý\nc—ƒ/ É˜2-Þ¼O‚„¢á™˜@çS¤N4UÆ‚PÇÔ‘Å\\}%QGqÈB\r[^G0e<	ƒ&ãé0S™8€r©&±Øü…#AÉPKY}t œÈQº\$‚›Iƒ+ÜªÔÃ•8¨ƒB0¤é<†Ìh5\rÇSRº9P¨:¢aKI ÐT\n\n>ŠœYgn4\nê·T:Shiê1zR‚ xL&ˆ±Îg`¢É¼ê 4NÆQ¸Þ 8'cI°Êg2œÄMyÔàd05‡CA§tt0˜¶ÂàS‘~­¦9¼þ†¦s­“=”×O¡\\‡£Ýõë• õF“qžò‰E:S*LÒ¡\0èU'¹«Õû(T#d	ƒHûE ÅqÌE”')xZœÅJA—©1Èþ Å®ƒè1@ƒ#Ð 9ªˆò¬£°D	séIUº*òÀƒ±\$ÊzKêÙ.r‘º¨S/äl˜ ÑÎ_')<E§¤©a'¤¹Js,r8H*ìAU*‰¹•dB8WÈ*Ô–EÂ>U#‰ÂŽRT™8#åÊ8D*„<‚_£ˆa˜EÉÎTÇIBý#êdÿ+Çò	lr’j¨HÎ³þA‘3Ì÷>È%Ê¨—E‚®Y§¥pîäÔ£•Eu x0µÊ3¡Ð:ƒ€æáxïa…ÃÈ6½ƒ(ä\rãÎŒ£u <8Cpæ4öD¨‡ÂHÚ86Ãm¢:xÂDaÄâ\rã#vÞŽm`¦(‰ƒK„æ#“ÕAééNE\$ÐŽháK ’J	se¢ûK°*ÁWaXft”)ÎM•ÐL.NÄA \nãä7=ƒ<HÝÒº¯<G‘ôå4sj9šÌ VQœä¬¸\"Vãê6\0ì0ƒ¨Ë%ÁÌE?GI,QÒvtÉÒÁÌR‡9hQ9¥Ùvs„|Ñ\nÑyËäFã¤x[kÄ\$o•±Ü{\$©o/\$Y+B6†67nKlcÂ7=7¢?œÙºeÐA³9Îû¥|Ódý@NÄRaxlÑÐ¥ûI=ŠôÔ©Ô¦\$<ñ¼¯=ý€`IéPT¾YFŽ´¼ð¬É@ø´â*Q%ä=ñ}Pç=NB\"§×væ£¦éïÖˆ940A“5ƒxÌ3\r–Mð—#õzRAHÈ¨7µão<„­¬Cc7!Ì340@xg=Ì°äÿg'°AFXº`u8@ 9‚“˜9ÀÂµ\rTÂ˜RÉÝ2¹#9D3lçh R—CÈ€ƒ7%ZüIA~©à*ÜÍÐfY¯õkžÐ@V:ÉP41­•®P VjÕ[«’¢ðd['”®UÎ¾»%D}½ˆ2†ÍX™>îõ'¡ALl?T.üƒ±±hu¡Â‡b· šC™ÂFÂD0î³WpeÀ4«`È¢Ò´\r\nÙ\\+¥x¯–ÂX‹då”³rÐZRIj­u²ÖØs[«}p®8Ìº\nŠê«±wÅÔCY¬^ÆÁe?©Lƒ¤hI~6ÈÞI‰ð‰<ÉÙVCxr‡D\nôDSXCt[¸sjá¬*%%Ä»ƒf‘N\"\0@ ç 4S’sCv\r`s+ˆ9,¸ÃKHg1 Ô„PšEDÏÈY‰àP	AÐÔ„èB„<DLèœii¼A™˜ Ë&0åUÑsFÖÌ¦œ,¥w›dm\r±¸]ÁÁf‡Ctqhoh­\"pË%Îl!„p•6?ö¬\"EHé\$GŠúED…Q>(Ž\"d4ÚI*˜jª¼Ilh¡†â|Æ)rI‡(¢!	U–)¯ ä-uA\$‹—ÌJî5Íx†ézqMÒ¶-*D‚\0Ìƒxm‰ñFSH³ˆ´h,^3þ¤\"N`P	áL*9ÅöŸQA&¢›ˆ Dr5®¶¹ê¨’š …ÕxaÍ‚ œ°‹]# T\nÔ‹^+%´SZéÍ©\nùM;Šœ†ú,gÎiày„Ë,mMa´V*Ïc ªß¨°U¢Ù{2âQ«YeäR	aÒ Þ+°.¢Sµ–Ú9EÓf	á8P T +‚\0ˆB`EÂEå©\$9Dx‚­xy7¦ùs.p®;®Ðóˆ@\"ªŠL>B ‰j£¡!ª¯P½g>TÕ¯S‹íÐ°“áŒäd,DFÞcÜ†è	0é|\rB@Wù³A·¯_\"!azÈT%ª‚5(@}Å0§¿Œ-«q-‡0…I…E—/´Õ™¹YÒ‚\n4(õ¤(Q©÷ãžŠ‰Tª¤xAŠÈÖ £i™ø\n\r‚1/Ï0’Òš]8[ði¥…0Êm§\rO=çÄù—QƒDTÔM!×©sõ!äU	}ºw@ÊÊ£l?¼·bóK«_AÂWdŠ-–‚]c#í¡Ð&‡¬ •+f‘‹_Ëý€ûÝtX±ÛBÄ¶GôvÅÜÚÏt“'¹ƒRŽ¨Ž%æp˜·:±#â¼¼ˆqty„Ùy»8^i’°ÚD7M!?o|µTjûHn‰èf\"C	\0‚É¬ Òn_:¶©60ßT@äpª†ûx‰ÑE±>V ÅI0\"K¸‚fÚhxåƒ|¨@LÞIÐÆÁ~‚è¶B®eç BGÐ@‚rIL:(aÌMæü¨AsÊ«ÏˆéÐß%b#ØyÊõY\rÌtIYJ)WyÑ—æ5.¦{‚')——RÚWÝ›M(ƒŸWÍ2hBÓBŠv)c–õ¥ÓDc\$¡Šß6Ÿ‰Š7{Ð½çÌ˜.‘äG<æ<µŠ\nhÖJÈå,€V¶_è÷s\"üŠÎ)Àå)LV°áÌ-„@åÂí\0Ûy¨v’2Œa1Êñ‘ÏŸJÉléŒ±¶:è˜°æÊ‹²t2\$þgÖšXÌ}.Í±ŒžÈÚ°‘ýÞ—¦˜‡êé?»éÿ\r8V8¦_z?˜@äÁÓmŽ\$ŒHåæjM.LäŠ¡\0>€ˆ³\0àD`~Re./ÁCM ™Î#æv0-Úð(m0>™¬ðV,IƒèkÎDÇFt¨þþÏžbfff*Ho&öŠN/%\"#`áåøÉç\\ýl‘OûL|S­ R!Ê\"néH Êâì°’É°†ËŒ ÿ,ÀKÿÌy,~Ö^bÏøÉh{§dùïÙçNÜ-l\$Íá\rÇ¹0¥Ü¡\"ÊßÂÂ*ŠÒv.ßN‘bŽ¬èŠì]Î¦+ú¿ìaŸ\r°¾ÛÑ%÷Ðb,Q\rÀÖ±6â°½Ï¼Úp˜'ŠÚâ>Û*^®&(ná+A 01.Io„ÂRˆî Ï¸Öj,4BÎ·p²Û\r´f\"ph„B3®°†qp0db+é\0MÃ	.°®J0°LkAxýÙ\r¢ÃŠö­£ÈÅ­‚`Ñ(Û‘æ	Ñ7°ÏÞm„ØŽ}éQé¯ôÌ1ìú1.þqðúqý ñàaÑHr¥þ.¡jAÈC(Á^ÁÊcô VdAÊÃg2:1\0Rñ\0§Ÿ g¥\"9%k¡Rá%‡¢r†¨IÍ¡!¬ÄHÚPî„¦)'Æ¥'o¸Ò%’€H2†cÒ\\'¡Ì¡M LðLPc&ì‹ ¯Û!/Ï+\"?+qÈ°çP2_rÉ\0²»!°é-2µ+‘Ï,A-dë)a~¥\0Hdþ«DNPÙãþ²òQÄˆÅJ·0\rÇcÏòô#òù“/ä—.s\nâSHÓ(rðß\rÙ¡+ó,\$ÞÜáÝ²gÑå4³?rÏ,¯5Ð/ðm'Í×6oI!ä¨F¤'‚®á¤îâ2÷0-Z#“HSRu³/8rpÌ ‘\n\0’kNÇvw¦<a0„wGx0¼bÏ~®\$|‚ò˜ªÌË+¡xæÞò+\"âý-È~Ò«! ˜¡:D=Ánã#¶ûûO¹6\"`è@Ø`Æ} Æ\r`@[+¾hæ’8gò] ÒÇø^Ã˜ËÐ]@ê²©Ò‚©È\n ¨ÀZ\0@Z(ª±Ú9ŽŒéÇDwáx&Ó<ÓG60\0ý/ðL¤iÌ¨+f¶ªl,à	´9CÒt9Ãï’2m&çŽT¤2#&éë*„\nÎÂz'óà1À˜\rë¼\r¥š5ƒ€9\0L¥Œe\"ò¯l¡ Á<‘Èy¢MA§üqC…ô¯Ô#v¦ýPãH'#)6”O/å40Ü\n‡äR5kÀ«@\rààœE×‡ßP4õQæØneo°kYK„æë²nÎåItÙ­—Vbì¸+h3B­`\nÉÀ ê\r´Â¤I!ÆÄxÔìzNB†%gŒ:f(I	ºTú8&–G†åÇ¦s°Æš…Nõ\noÂë\\UÙ•uÝRá,r¹\ròê#ìï:ÁG,U7dxø“vU’B0@";break;case"ko":$f="ìE©©dHÚ•L@Ž¥’ØŠZºÑh‡Rå?	EÃ30Ø´D¨Äc±:¼“!#Ét+­Bœu¤Ódª‚<ˆLJÐÐøŒN\$¤H¤’iBvrìZÌˆ2Xê\\,S™\n…%“É–‘å\nÑØžVAá*zc±*ŠžD‘ú°0Œ†cA¨Øn8È¡´R`ìM¤iëóµXZ:×	JÔêÓ>€Ð]¨åÃ±N‘¿ —µô,Š	v%çqU°Y7Dƒ	ØÊ 7Ä‘¤ìi6LæS˜€é²:œ†¦¼èh4ïN†æ‚ìP +ê[ÿG§bu,æÝ”#±êô“Ê^ÇhA?“IRéòÙ(êX E=i¤ÜgÌ«z	Ëú[*KŒÉXvEJôLd£ ÄÉ*é„\n`¾©J<A@p*Ä€?DY8v\"¦9ªê#@N±%ypÄCµ² QÖV2¤ñ ÐÀ'd1*ûØèAðaÚL«ùUÇËü<ø‹üPËI§YL©6Fªr\r\"P’Å-È§YTT¥ÄìdF–\nÑÚBBhj´‡ÄREÌÇa˜RluÇ±²´u”Ò‰rBo‰ÖYq3Í1D×6¡ÒyRFIyÔ[²¤í'Qk”	ØN‰rgSRôÍ-Xä2ŒÁèD4ƒ à9‡Ax^;×pÂ2\r¯°Ê9Ãxä3…ã(Ýd(Ü9#}–*ð’6Ž\rÈÛeà^0‡ÑAm¸ãxÈß8›^)Š\"`Òâ¨'\\Ñ5M’í>v%„dY–“ÎYaz‘0óûà%–ƒ•³Ró”äbbRB@P®0ŽCsì3Ä-ÏB±”tª¿’ðä¿—¤¡ÖT“nGdy2vÄëàù•€Â:ƒ @;#`ê2¯ä!@vs2T‰ÂþË ð2édLdU	‰@ê’§Y@VdÑþ?k6Æ±¾J“'*…3 (¬#gƒc|æ7!\0æ1Œ#sçv¼åRZP9\$rë<teéHMôž/ô™ÚA‡YNDqøW\"rœ·0v=Ù½íß2ém,¯ænèEq(¨ÆD~A7ï`Ã1Q)ˆbDŸ_}^TiiGÐôŠ½IB\"­8r|¯/¢èúHžŽM;Rc\rxÞ3Ãe…xÒÔÂÌî“d*\ríÛ¾!\0ëgŽ£ÆÞc6x\rƒxÎûac|Ÿhaá„û\nÇ—ö§0RsÌ\"bc¬H0†ÂF Â£ˆ`9!KüÄ»!Ø(É@‹C¨}¾ø„«ä|ÁPÖàÖoC2Æ}Ë@û‚\0‚°rÁi-\0È°Á¬UÊÁY@Dƒ\"Ò8Œmo.ž!¨…'.Y‰\n1B<ï…U!¸TBqA	¡„9œPälã`sës†PðJ¯‚%…^¬UšµVêå]«Õ~°CrÃX«d¬¸ì³–‚ÒëP9­e°¶–äU\\%Qq†UÊ¹Íúã!¬×®óf°ß\\‰\rÁÒ+Å”J“Ú<ŒÐ®4¾pÐkÃc‹D7\0în°b5áÁaÃä¶×8aÑ¹½?æß«÷/î^ËóŽo¥»z+l8ô·KAfI!\$…\r¢Eæ˜(€ ƒPyã\0 ª–nG’˜ì( H”\0‹qd#Åžu£†´¤Lºck Ù›SnnMÚç:Ó’l{>h/ä;†Xö_àˆª‚pV1ÂõT×bPÂ(ò:’<RGYK&Š™t)Eá\$d^4\\i@Dc®œrú gCÒÔ\$‘ÐòõÃ i\\æÅŸ. Ý(A½UáÅ¡ÆÐ@ƒo\r°ú H˜ÞqÖTÝ+ªlQpá\0ƒ)A\n<)…CÎ¼ÔrlžéHµŠÂ¶–Eé¥25Ýá(òšSÊD§#°RÔP:…ŠAK‰;\nD€…‹âÕ&ZB×¬j›ä½8/å_½€@ƒHg°&UópkÍº­ÁRw·ÕÎVÅ€Ìú°V&ô°ÍrÄ/âd\\±lSk\\kÍ€'„à@B€D!P\"€«š E	ê8b<ŠzU|’±X˜Œën+MË\nŠèyñ/â@—øb`Ëóe¸”R((©ëÃÃMÆÙa<Kj\nñÀ/7)'+QQÑúrŸPR€â«ËŒÁÖ*|=;,ãEžx./`çxÄØ¨íŠ—§c*ã˜re_gI§ËèÒäœPçtP¢¨ÿ§lï³–yE+I\0:DwÌµ’ô\"v§Ð¨¹M}‚;“|ÃHzh”l@¶ˆÃ)¹—TxüŸ»ù¯ùrNuçÆ¸Ý8^öZ\\æÜ2‡uöí—Ó¸`ÂRùˆ’L¦ÔÒò)ÁÌ°3¼I^CHa\"¹Ùq.5Ès¸AÐß&]qlÝÏ)V¤i£Û|O’œSÂ±ˆ²Ø0Q9Ì:Å¨¢-Þd•^#Ã(	#ìNï˜­Ó\n!„€AWi7aWÑŠªph˜r8´|võKféK®¨…úð@FW;r/ûZ¤aÂ\0@ˆ&¨Â¡@†åfÝD÷vöãºI­6 ñÝÞ†¼.gI£Þ†šm]¯yð†÷;ÎÁa}Ï¸—rÁgÕ„;¢BFV,X˜¼úeÛ”2NJÉi/&\$,ø¢ËûHÈH—§ü\r§dðwO_.#Ü)‹PÅ>9yãÔç#qtL'e‡4ÛB•¶Ö\n•Œ&[P¢¶ï0‘Cèy°§¼Ë„Ú»YdØÉ™S.^˜jcBØDýðÌØr>E´q-ÊøiA“Œ3´ô.fð?fÞ¹W=ö1„°§oÂÆI‚Þ¼H½ïF›=xfBJ¢ã4=Ã³øÓÁÓúd†0S¤ÙÎ,ÅÁðO&°‡FF8¾³M1h«ú¡Ùë=H‹õeðy¯D“®(ÐjO½âÂ¼_-Ð>ëB2tq<ïR()8Äù­u€°ÓÇÁö/¿ö_ºÍ7ÏÁ8mŸkc¼€°=âøÊò¯†>†%ú^õˆù/ÍöÚÀx7õÔ_}â~Ío8µáªÂoò9ïösÍÌÒ¡\0'6y°þÏ~ñO®åŽ¸Œ¢FMbÖb¼îÅÕ0*mÂ3îìþíåîâ¸kŠ¸âÒkÂm5\r­\$úm!ÐþÏÚwÏ&üã\0000O@<á`ãÎ)ll\"Wâ˜f&f\$âÀ\nM„ÀÕÄÞ@Ì§¡*LŒp!R®¤#Áv¼á>%Ö»ïr÷k,0ŽÁjôä¥ð+ÂÀ â¼°©\nÎ÷­#å(òÇtÑ§4øëàtO|Ï{°éÎÿÏeùªrò0pýð ^!n*Qwî®ð/(ïp@øDìñ'/àÂñ2lðoˆÐÃ0D%¨¼FANr¥¸cºb Á6–:`ÖMh×ñ)0,Ð°)B·lR¦˜'\nS\$”Cã£–i¨·f*›‡`P¦Z\"rÕ¤éaÚ¤÷Œ!K#„=ñÃú>0Xln]/ñpçÄï\r	Åô–\$\n×Ë.HD‰\nììCM„úGëÜ¥1¸®Ç\0ÐXGqúFÂ=!r\0Na;Ò%!2*H1· \$éŒRÓ2²-Ía\r.Ó²M‘ãï\$‚Ÿ%«\"F2W\$±%¢E&M=Q–I˜Píp×’&Gïþl’6×Ñ•!™G`	Ø–àÉ0,tÇPTëŽ4&ÀGO	b<æ˜ÁÜÅeLÅÄàÃƒàAì&#ÑRÖ\$Ÿ±=åö¬Ì#ò2cÄºÜ&qQRÊcÒØØíÒ` Àè@Ø`Æ{ÀÆ\r`@ZKLh„8ÇÔ\\ÀÒÇÚ]â‚Ë^\\`ê«É„€Éz\n ¨ÀZ\0@YHˆª#îîP:ÏÎìua@u¡21‘>ðŒ¬ñì:i>ß1 1Óv@›3S8K¡h`!fI®º2Ã0rÍLKSžëã&Ab¼,‘X !\0rÆ¬	€Þ´ ÚXÃ^8c–SÀWæ6ë&´B!d\nxïBÓ}æø8²Tð¯/7Ä@Â%‹ág/0ÿ3å?nýònÂà¨o\r–5ƒ\\´àÊ­ Þ	vX,å7Œö§ƒÏ/Ð°Æ¦ÆÆ¬4/8J0Ð*O’Ö°ÆÐ”Vd„†¶Ü@¬— ê Ú/â’:\rM7\$dÑbiIÊSRîÔgÎSì8†ˆ'êˆEoäú2ÖÉÄþfR‡J}@ÍQñÀNœ%Üiã¤½Îfä„ôCÀt¸ÁB>\0";break;case"lt":$f="T4šÎFHü%ÌÂ˜(œe8NÇ“Y¼@ÄWšÌ¦Ã¡¤@f‚\râàQ4Âk9šM¦aÔçÅŒ‡“!¦^-	Nd)!Ba—›Œ¦S9êlt:›ÍF €0Œ†cA¨Øn8‚©Ui0‚ç#IœÒn–P!ÌD¼@l2›Ž‘³Kg\$)L†=&:\nb+ uÃÍül·F0j´²o:ˆ\r#(€Ý8YÆ›œË/:EŽ§ÝÌ@t4M´æÂHI®Ì'S9¾ÿ°Pì¶›hñ¤å§b&NqÑÊõ|‰J˜ˆPVãuµâo¢êü^<k49`¢Ÿ\$Üg,—#H(—,1XIÛ3&òì7ö4Ù»,AuPˆËdtÜº–iÈæž§ézˆ£8jJ–’\nƒ*P:-B°Â94-Ô»4ãJ\"òŠcZ¯,(ˆ0Â»~6 ò\"Ã(Ô2Â:lð¬ã\\P†ˆã(Þ6Æ\"–î9lZî(ã*Vî£”Z²!°”(Û)KP§Š_\ré¬V¤Çƒt0ôK`(IƒHÔ:»ëø  4#²\\ýL³;¾•-AàÂÉ8Ã0z\r è8aÐ^Žô(\\0ŒƒjÏ\$…ËÎ®4€ð¹ÉHÞ7át	#k÷#.# xŒ!ôGD²Ó´C›*)Š\"c²2¤‚èñn É..1˜¥,ºÈen:×&)V9;kÊö¾·\0ì‚C%’ãÙŽ\"à¹#nÞ:©i{0«‹P¯	¿îúŒÒì¨\0MÑu ƒ:	w]7Xè»;Š@Ø8.ˆj\0ˆ¡¢\\wPÂkP‚:´!\0’7n4º:B Ê¨åœ–£([Wø4\rcÌ7¡¢Îã^Y~\$Œªâ*¿³c˜ê9B’4¯Ï*W+­ƒRT‹–xåU•_Ðs†‹3‹4š2 #šV†ãã`ØÕµ¬¨æ1Œ#s¹X„¬¯6m\r+ØäëOÃž÷YKærWx½\0ÌÐ—¨8hö¶4HÎØ§bfn&ÿÀ¹‚%y»Þ	.—ðò<È4³lîF†Ó£‚Ç¤B*QÍB’—	\n#Öºæþ Vë.ËãˆˆNàÇÀHñ&:ò£™£ÈÂl¨Þ3ÃeZŽ‰Lä3¯â Þ‹%cpó°Ò£¨Æ1³ã˜ÍŠ­ãzÍJ…>Ö9;î7'7M7a(P9…)\"¹¦Ë=ä—ˆb˜¤#UˆÒÑ„ºLÏ“Z@\rô–0ÚÉ£‹5M¨!ä(rÉ JXÄ½<dÐÏé•}X”œ4ŒÉa“\rÄ¢›ò\\ü\0AQ*,9=ÐÆ¥ÉHdI ;'†&žÉÐ\"Ç´´àÎ¨Õ)\$\nf}Ë‚äðŠRt%ë®8ðÒ“‚ÐYŸr¸e˜j\$d•6C6\0Ã¹c]!”<|^¢„5\r	å=§Ôþ T…ê” ä£C’R1‘J)e0¦ƒšœSÅÁ‡ÄLN•B0\r\n­„’²4}Ã¡úI/5PÄ(ˆ…Ð	E<µ3NÌÈðbXÇŒ<v‘L¨aduK‚\0îg¸b2«ð9h^Ÿ\0f.fý™=7ªõÚ¹\"{r¸ì†ƒNà`aG€†—¥BXb-eµ;Ÿ³úCHoše¸¡ãèeâ±ù“H¥¡€ ú?‚\\ÿ \0@\n	ÓíA\rK”)W\nI™r†p¢K‡@ñO¹A6Ï«ðïr0oÈO¨¦Y <	nÁæic|aB¨\$ä¤•’Ò^\\JW,µ •ö]ÁØAÄÚ(&²jMb¡¦'F¼…‡“ ÝI– j¸7.“PjŽ0qc'‡\$w\nc¬35Æf%]1ÍQ3Ä(C2öm\"ˆO\naR‰:Âî;ÈÖ*º²ãJCJ#€9“ô¢Md4ÄT7bÊ±ˆ* á¢I:}©˜\nws1®¶öÔCà]E–°6\nì\\q`*N—þ}Ôó›’£ªä”£i\\,hÈ‚RNŒ@Tš/n%1°èZágk¬@Ü+{d\\—Ë_‘\"·¬úakSYU5Þ×þÔÎhliÄ8—!\0é'R“ZS°ë“·UZ”‚¾È‡\"¸¾.Á#„y+¤`ò×“ZáxG’„¿RwÓ½fqäK’GÝkŽ%äD´3rå@7ÈÕ]8»ò¶œkp¤zù`wR™{Ôt• ®BZ‚YgB\n)P…Ë‰a‘	-ãt©å¤Qªk†êÖN“q‚ç—¡ä5‰ñ‚¶¶úöËVŒ®@LT+eÇ¤@ôÆ§¢ž}) ¸J²õ€oV<¯¾…ßìÒ1L‹’îhœŽºO wHK/²–Äë9´õ¥\$6âµMîl%¸Q@K'jþj(Ýš­FsŒ[L×œ6]Â®NÙâ,©%è¦q-±žY¿\0´³6eŠMF/v„P¢ÖúÕ 2\$-XAêJðÉ\0®\"ga!ßt»Eã£8	\n”£¶B T!\$\n…£ýlƒTìÑÏúäÙ{l-â”Æ—x/)Ë½o®æ½šB\r;cj˜Áf‚®Ìl©ÜŒj²f„)i'o”gjL,Pp	Ü\"ù²íÈ+÷1…)‘Gur=»vÖñÞ{ÔÙ=óº7á(éß€ac6Ó¾æœ¨±oM›„Ë¹]<W‚o~S6Çâð#r‘MÏ9â%Èc’†½Ï–‚·&mìœZÕ	‰Ó\re±á\\‚|g9aç‘*pÊmá§bIIsdsôn©ÏÇI³å’ms\\°IœpW4Önr<gíœ\rÙ9¹`iØˆ&f9­-p³ÃclÍíÍ˜çC‰yø¶ÅË£÷}ß~÷í}š]ûkH†e‚ÒÍœ¶Vü£ß	'‹È•¿…Wß#çYÖYkÉN¿o²jhDáÒò@Jàm-ž#é‹Ÿ:Ù÷ªq58 \"‡MñÃX5H–Ã°ƒ™ÿH~ãàó0D®5­ôá¯Ôú¼×‰E¥\">TŽšüäÚJKêÝš PÓI°)À>‚ã–­]YÛÃ®ñ·ñá¬µùïŸêòI%\\mÐÄp7éqÞkÄàÀïæúmÖË@¦ËVñÌ.½oï\0§hNïp°	\0Éªð/îêÎ¼Æ,\"/JðãÎdáÚÏ)\0d-IEŽ¯ÅÒÛ¯¥ˆŸŠŒÔ°6àÐ:ßp>ÛÐBác^´CÆ¨N(%ÜšCpÐ|W0\0NxFB^Ðê3ï\$ŒìÏdiƒ~#¢P½cT¤Ïº4	@]IF#Éòm\r‚#§4{°´p¸™F´û‚6\$^“âÉAV8‹`=¢–“ÂÎúdï#~¾J)Ž¾(¢Žg0v0	ð~ÏP¶,ïtÌˆÀ/¨<«¤ÐP¼[-(Ì…£	0(èñ8ÌÐƒQ@ZE\nINÖ/ú›ÑL;cÕj¢ÝñHðmT\"‘búŽû£°r6šNæY®Z#TÁphçm(L…¤BÂMh˜,#Î!±^äÊDMæÜ6c¡ÐcÂÜ\"/þðJÔÐO/-e1PËFößÂ>dT;qÒer¡±³9Œ‡®„qÛÍeP3ƒ¶ñê¤KŽû&\0I=oÜ’Òòqp\$‘ÞpÊÕ‘Vé.v9…ÿÑºèò7úèò'„4ër/\r\r,%2:šM%o]%M\$ šRF{ÍÒq†t’tÒQ„	„R-Q£lÆBmj[©ÂïqRIÒ’&Gp”o¢I)Ä¡)QÎšLì\r ÌBüÔqçmb~âµÅÂX‚þ]ã30þõÂ-\ràÛÖÂKJ}n6qâÞ2Õ.1-ÒðþíRìþ]î¢f)´	Æ-òÊMrd|­²ïíã1ÖßðVÝÅÃó%	sÛ®en\r€Vg„`Ö	Zâ&02©K2¸yã²'©øUš]C*|@ª\n€Œ pâ…ê`âIð€#ÄÝ\r¹2Ì.#Óˆ»P_îƒ8¬´!â0y¤vNçlÀ‡Jóœ	³XÀòf ò+8Å–Ïàœ,bØ/e8¬üY£ŒõBõA2‹\0ê=¨=…–9*\"ƒm4‚Æ%Ä¨Ff\0ÁLòh«|ÂÆ2£J, ™@çäFcŒF*¹ÂÔó¯V]@êÆ˜+‚¶#ü4/;Gþ“ŠÀ1D§Ð\"¨ÌLä¡DlÓC1¹,4À\0¨5‚à%ã&E³h©€ÞJ¢TËÊE1\0bìÊHfXeÅšÁ¤O<cDœô„fÿäü0úæ˜¹Dg(BmC‚^>”DÕ-µ(àÆ ê\r 	ô€QT(=À‚-…M¤ÔmÊLF æm€¨lTANËÃ9ƒ¦«¬ªºý[Tþ¼cÍGäÌÏè†\"¤p jìEK˜ÓC\n2)6ÁGT5„&";break;case"ms":$f="A7\"„æt4ÁBQpÌÌ 9‚‰§S	Ð@n0šMb4dØ 3˜d&Áp(§=G#Âi„Ös4›N¦ÑäÂn3ˆ†“–0r5ÍÄ°Âh	Nd))WFÎçSQÔÉ%†Ìh5\rÇQ¬Þs7ÎPca¤T4Ñ fª\$RH\n*˜¨ñ(1Ô×A7[î0!èäi9É`J„ºXe6œ¦é±¤@k2â!Ó)ÜÃBÉ/ØùÆBk4›²×C%ØA©4ÉJs.g‘¡@Ñ	´Å“œoF‰6ÓsB–œïØ”èe9NyCJ|yã`J#h(…GƒuHù>®Î òo(ÔƒœTë¼ßp(Tªl®§U«ÉŽ˜{Q*|Ä ‰ðÎ3¼€Pœ7·Ãxä·Œ,8Ö¤7IcÂï50jÜ)&ã:‚¸°\"8Ë9Ì:LŸA¨ËŠƒ²\0P 2¨É³'7¨á@ˆÀ%¢¨Œ6\"ŽÔ2 ¨ÍÚ::¢`Þœ¹+ð#Iê6ÌH\0PxÊ3¡Ð:ƒ€æáxï1…Ê ÚÔºt3…éôÚ<9ãr`´…á”<hÃ\0ã|q*’9„\rFÎ'ª\\¡\nbˆ˜4¹é( 4­°„s(*€¡ îˆÖÑAkÊŽ‚S1+Q)\rbì	.zhÃ P¯µIÂ\"ŒŒ(òç5Åtç¢\"Xß;¯óU`Ä—#J‚:Žƒ|\rJ#!wRt¨#8	„U\$R²C\"0\",'p’0¥±°¦é2`U:º,¢Fã+jº'\nž—B\n^·	-óÂÝÆcpëT®£Ù€ŽOwF‰€S~ IƒqS¸u\"q 8ò\"ñŽŽlÂZï\"ˆ¶JÓ\$Ù4eáÙ«e³I‹:Ï°8(á€PŠ—çc–z!B¡U‡M¬5˜ÈT¸ˆ!e¹`áJ\r. Øýà(\n9Œ­Òr7ŒÃ2Ú7©,˜ËÅˆ¤*:ÛÞ½:ˆÜf9nqkHð“”ÅÉÊB‘…ˆ…©@nÖ²DË(­îô×Ó;T:\$¢ ÞÌ7b¦)Á½£@\\<Ò¢o\"L,¹²,£íŒ—¼³äÂº¢mÈº	Š ¦\nC1ˆ£\r\$ò9‚ÉÇ:æÍî[wC#r˜A*ÊòÊ”Ô@Èè%³äüÙ©‡5Tqã\$:p)ƒÎ6o2LžÈ/KjKHœ7eçÈ‰oÆõÚÃ¯ÎçÞ“ÔK	i.%äÀ˜“\"fMÉ5\$Ø›ƒ*p'ÉÌ7'TîžTXn{Éý@±¡Cq¢#j 3†T€`¡²re¤›¶¸ø›š<'EÅO†Ì`ˆh¥1‚Òº”#äõ\0‡ Ì‚Œâ¹!˜çºS”Ãáa˜:‘÷ØëMÜA…\"-Ã³ÚgV{p„¸†Ã`‹‘ð7ëôÛØ×A\0P	@šº€PRL3-˜œ9 ÒTbT*ÊHëÆãänÌÁg‘Ö>³S8g£ô€'dôŸÃ†Kß‘1Ît’´Dƒ\"Jþ|… ÎÀÊš©–\rF™&‰Ønsî†?1ò*s \n	K4¡µ©5Ð«„.Í¹¸äˆP:BÀã<ˆœàÍ¢M˜®Ó^j‰(DG1Ä'…0¨øÃ“nv‡¶–Ô¡ÌHd\ržò-ƒ¡Ì9éÚ¨3/ƒÃ²‘”‘r2FÈê”t\n:VÎ7g)Xpu2Á*GD\"m\$]G†Y¢ÒnüÌœè(dÀµ5†Q¡ñ	á8P T *‘‚\0ˆB`E¥H™u†Lé£úFh&S†ìqZûC\$Ý5I„ƒ1Ho§6&#¨ó}å\r\"¢c¤Iz3Ç!#ÐÎ¦%²A™OÕÍ›Ç=X]boíQ“²èhƒD–[-UV–d…Jd\r5‘9`µC€r,ï…oÓÉ÷OÏÑî\"!Xè>\"” ý¡QªCÇæ ÝzMog4½Ód\nR#\$.•“?Üèù\r%¦]0ÖIÃHzFá¥ˆ–ó ÔÖÐJ=Ç)²éY”’¥xDÃ,å	´ÇGÊjÖšÖH&\"*¢k½¶\0»ÍñÐ\$Ç…à22ö#r£\rtdËcSWã‰>Š&ˆˆÞ\n’€Cuë:Jah\$ ÒY¥vWt#D‚*‚’Ð5+|ÃpÒg€TÚdM¼£D\nC©Ð.Ñ-~NãÜ,\$¨b*Cpˆr\$-\\‚ðA‰*\"8C	aGl@ÉÙF%äÞ¸|aM\rA”ºFráQ,Â„Šã#Úž¨¾(Ä´ž‡,_‘IvGƒ-›(ã@½ÕÎ8\"\$LŠÏâ4J”¡Ÿ¤c/Ð>Nå\\Ÿ›3.Š†\\¶É^mEÇ4ö™èûhmÒA9™˜ïu4¼b4L)£˜´1gµøº1¹cZ­Þ=†@Š*Å][€i ¤6ÉeZd4Ä3eÌ”Ø]>JV¡'oºK[«œGÎ{ü­ÖïVÚíTiù%ÕÆ»XÖÒxÊI*0M‡“í‹Ö£«f%ºÝW	pÈQÛhJBÕ›¸HF–‚˜Út†œ²ý·µV™F`—D—ë}s.ú„ºYd,@@\nÅB€§nÖŠ÷XÈ½Ó5½…×&aZ¦Þú†p‰Ù‘‚[pk2ÖæüŠðŠí_7Ì£†{žÞšmo¿+ŽIâ¯ëI=€Ôxç'{œí¨œÃ€g~·iN´6cl³Š§;Ç´bøÞZ8NxèiãX%ÞJ7y÷1Ãæ”jóGÞsÃ‚7¦äÐå]—J„Olä(PÄ÷™Ã\"dÌ«FÝ;â‚ÅðÂàMNì†}Pæi·wÒÍçRi¼B‚“³¢UJ”‚?<÷šóóû­ºŠ¦-åùÔ†:Y–&…TÝ£Ü5(µ—:Ö™\$íøswÑøþeþ;3Y!ÎyßŒw8Ëò-qÐ¼¯œâ>'¤[¨Üü±ÕòQÔæ\"•Ã¨\"5ø„)œ5L|¦ è[²tXøHÍDå§‹ø¹e€0óÛŸáü¯IÇî¤TVÅ»ÓØ&¸kP_«úAoz»`þÆèXà€)åè`B¢ô¾¿;_yŸúNŠäá|ø~¿	Yî¢ ýl£.ÿ¥ÈüLróÏÜ×N¶òÒN´Xïø\"ÌwKò¾EóŒ‹âüÐ\"ùoAð,þpôëÕÐ¾ /ƒÚô\"ÁòxgƒMœóE=.räŒo<ô¯`htìúDC¾H†WÏ¾…ínÏâç‡Ø0%|kˆ:wgÂm#¢¨à'ÂÅ ÔÇLx ÂJcö\r€VbÚfä#TÜL†Pã ì Â>ª3Œ™BŒ&†„¢ÌB ª\n€Œ p\$¬nær¢„„ÎR¢„Ø‹~É¬^¨¦´Êã„à±0Tì§ðÒ˜0ÎZ­Jöæ¨‚\\\rhuéX”ÉPRÆDHÂˆ¼âÊ_E :Kí	äy\n*ˆ×fÖåÚifJÉ1lÖ<jf´ã/­n=¦Æ×Mmû‘’óÀÞ6&mjÕé”ankÊˆ\\Ãë‡&ˆgÀÜØêÀ_‚rÁCªä±È\rÖºOn~ ŒJÀÊ;ÌT@¬&ê§\0š@QŸ#»(ØaÃ1*Æqä#BÝ1rw‘ Q„m\nêÞêÖ©mÄ;PØ·’\0ýÔÿñzS9.\"F¸7æzs`";break;case"nl":$f="W2™N‚¨€ÑŒ¦³)È~\n‹†faÌO7Mæs)°Òj5ˆFS™ÐÂn2†X!ÀØo0™¦áp(ša<M§Sl¨ÞeŽ2³tŠI&”Ìç#y¼é+Nb)Ì…5!Qäò“q¦;å9¬Ô`1ÆƒQ°Üp9 &pQ¼äi3šMÐ`(¢É¤fË”ÐY;ÃM`¢¤þÃ@™ß°¹ªÈ\n,›à¦ƒ	ÚXn7ˆs±¦å©4'S’‡,:*R£	Šå5'œt)<_u¼¢ÌÄã”ÈåFÄœ¡†íöìÃ'5Æ‘¸Ã>2ããœÂžvõt+CNñþ6D©Ï¾ßÌG#©§êö{„Ÿ†o6væB)âˆ9«Ã˜tªjÂ´”(É+žŽHÉ±ˆZJÉ=oj9)C*d3/CI†U¡¯Øè<Ž	#\$“0Œˆˆ¡§ãò0ëÐÂ4Á¡8°&h°œ9/xÊ7¨î2Bb>’ÅJj0Ži ó\$£h)¡®\$(øÂã›¬0ÊB¸Â1 î¦¸ TVÁI’ ’7%ã;¶Ã£ÃR(çÈä‚6€PxëhÌ„SèÝAx^;Ñrb6¯Hh\\»ázgI?ÑÈÒ±áª	#j](¦c xŒ!ôH-ˆÞ”µH\$š\nbŒŒ•¦«üp7*rjä1¥pk˜Æ¬H¨èöWƒ¨ê9B²¼;„ á&IµûjŽÙ©=ž9Ú Pœ¯¶`Ò•Ë®¢»:¢Á*R1)Xs\$WLL%¿H‚ É3¨#­Z7'’\nï:ÌÃ(Ì0Ž£b;#`ë\"	p#£uy‰1±C\"-'îZêâa²ší^²\"Ì—Ä©C2Ä®T\"5¤¡\n3¥wæ/bŒ#hÛ%ƒ˜ÆÞÖ\"`@7µ£”¿0®¹K#¢9ÍìÏ%Õöu ÈŠs¢ë¼cPô¼jš°Úëëøöž1M(®¼0BË0(€U:8dhk\"\"€å’ZLªŒŒ8ó]4I³0…)ìàP×‰aVC2‚º‰`Þ3dôjj*Ûólß`U	8ò‚W¨Æ1¤ƒ˜Í„æHÚô9º660ŒñšŠ½*‰M€%a@æ·ª:2/\0†)ŠB2|å…ÁÃ–3Žƒ c2ì£Èn†8+£-»Éò¨Û·\$àÎ2&¢£87fœãŽ°ê#'f†º#Å\08ÁöƒOÔªÃ\"ÄPÎú£T®Mf\$Õ°WŠ‰S8Œ ²þôLóÓz«t¨˜XåŒ¹7Ik‡4ÆqOãuFˆiâ¿túÁ”‚PŠDuû”hrQáÉH©3úÔ¸nS*m·—%ð¨•\"¦*ª …VOœÉ*\$\r–µòö¾IªT€ä‘Tòˆ÷øt\r&y’>aŸ,‹0ä6tHÍ\r|é”†Ì¯H«žtaÑ†ÇJ^J)ã6\$¨ƒ‘T¸K\r&Kä4°Ô _Î7RÉDR‚ïà \n (Bq	>6A­²@@\n\n«¸KØ7¶.úÕi£‹f˜È–ì\n™³4\r†’óø»ºO\rr;ó g•Á5&ää“ÔèŠ»8Džàèñ^<F#hš„’(LÑÒ\r%p§Rf«\r‘SA¡Å‡³ÌS	ëí}çØœ ÆKÕy±6k<ŽP Â˜T­üë›2 RÊlÏxÆ(¹;÷ŽÉ| ólé\$¦†E\$ÒçH–D7äàgXð\0002“WùE5„¼˜¬ÒDïZæ•‡B‚\0Œ\$©[**y‘Ä·Í:&ðr8„Ô#`Ê^\n)Ià)ùH\0Xˆ¸NT(@‚-I\"„À‹T\0Rð%áµ-¥  u#ú½«©™³DˆnbÒ&\nÇàýOÓxO\r´H‹†×¼²OänG0ŒHùy?\"M&­4ÀªòŽ4¸°Š½]6¶ð™’UŒD°™ S#šqBaXêHSÕ	3É\\¶äÕL’’’ZE EøIÓ³»Y¡±ZçÌIÌ^Õ´˜Å¦ŠNài!R ü‘¢»%iåãµ“Ë_%ÔlÄ¯Ì#^]ØmÂCT°2‡u’²íñƒmÅŒ<ÖL¯)EjK`È„\"˜s!?/¡k53™Ofhg¨!•ÕÙFúy‹ºn!¤X*`8qÓ¥•9@†ÄåCËÑ‹rÐÇ¬‹ð×Ê\n²á½ÐEŽ‰‚,À–@“%t,ô°Mÿ9•<*†ä!¨f£YgC„¯„ŒLÍ7aŒƒy\"¤‚†eúë%&TÈ…H\"ß,üâØe^ãFo³<äâæÏhtÊh‡+d²?2Ã(Ãá¸;üw#^˜dhÍ°áfTK0©—]™Í‡8äIvÌ9Œâ‚ì•ŒrzOŽ.@Œ£˜ŽÎTO8O<œÄŒ£`oäX¬ ¤HÉ„ƒezzA’ÚI©Mžƒ\$‰‚ÿ§‚kg\n*M§D4\0Å¬Ž\"	)¤ªê=w£ôªS5Xæe‘÷Í@PE|‹Qç\\sXŒ‰“EzA•-jT–ÈAE%L‘£ÛÌ¸&Hr¹È†jîèG¼ÏmË‚!š©\\%ÁçoGqè[Âµ7;,I›«yo‹`ÕòÛá·õŽ²¨Ý„VÎ| ü'QB˜!«íÝoÃšöôðÑÔ‹U¤‹q>7+^:šŠóŸÖ÷º7ÜÕ¼„©zU•âOAC3%`¥mô¥bóÅ‡±6È¶RuIøm±\\õ¨ïü0÷W8äûè’ÅÏ¸w¬¸j·Pëïžºº›W{e­½÷±…2¥–³kèý3.H\rYdçô\r†ðïeÕXW´;Ôp°?mÝWâŸß APº…zÞÝò wûùÒ÷M<§ÞÀunôV/x-EÇJù¾^¾\"©8L0¢¼Â1ûŸœ±ÅàÔŽ‹Ò#D É—«Ñ®“£Ó¢sËªƒåäIÁ8þ¬àr:kÑ	,ôre}o	ßªf¾FŽ×†ŒXÕ÷.«g`í•w|G)»ÿczx)qõÖgŽà?oðßæ=ˆUe‹¿vÄnM“ˆ¿T ß>'÷þ““z7þ«å½ÁÖæþRcÀ¦\$ÆîØFˆmÄ4nFVáe|¬>æ) Ò;ì4ìl<F¯Øçp*ÃŽÈF¯æûNá«&wN®§†*fïú¾Ð6î0<¾«Ø¾ðN­&öÁPWPfÅFÒ EŽ0.ZJŒdbÎrÜO¼Š Ëç@épJJpŠað€ëb>ë®¥	bgî¸kƒ¹\nP›€¨^ý­íoJüNÜ^oK\n§/´ÀÇ¥/ÜÀ¢ðÀï²é£\rLÿ/Ç\rÌ ÜÿÅncÀ¨'DˆýòÄÃÝ\rntýÃàÄðôååq®bþ3€æ äò\nLzàÃ!bf‰ëÆXbcÅØ4p8*cPØl¹®Çç¸\$¦ˆé*F\r'@Ö…ØvT_Bû\0fˆe,Ž[ä£1V%1€\r¢§ðäe†\r€V\rb<\$&ˆ?ƒ„ánFqÂz&BÎã1C.ÊV'fb`\n ¨ÀZ\\~GxN¢jÊíŒþç¸ÍJhnâÐ­Éˆòø)Í!_bVýÂ0#B‚#âBùˆì*WŠö&ÅV\r ÌÈFÔ(N8Mº1Q\$#ö#ÇÈ\0E\"£”F‡àË1¨8£`%Ì2ê¾Ð7‰`f ˜Ô(ªF©øH­C.K¤A¬üaDÞë€þ-J(\"æÞ+~0²„ób%Ä@ˆ6Ž8F¶ôïhh‚½\r²£2L(°Ùãj.B¦3ˆ\"\$c…\"t»RŒ0róe–\"Æ9Ç^(«\0M-’N®iæd¬¦jä ñ/\$êf²ð\nÃ*m,Î9‹8eŒJJÐ'K²I­h#¬\r„Ÿ«ˆ_\"˜.Mh	%bú	ƒ!0Ò—%Â¦Klú„è„ˆxò˜(b,^\0à+Ï£Ð˜Žg	¬î ß%n%D`	\0@š	 t\n`¦";break;case"no":$f="E9‡QÌÒk5™NCðP”\\33AAD³©¸ÜeAá\"a„ætŒÎ˜Òl‰¦\\Úu6ˆ’xéÒA%“ÇØkƒ‘ÈÊl9Æ!B)Ì…)#IÌ¦á–ZiÂ¨q£,¤@\nFC1 Ôl7AGCy´o9Læ“q„Ø\n\$›Œô¹‘„Å?6B¥%#)’Õ\nÌ³hÌZárºŒ&KÐ(‰6˜nW˜úmj4`éqƒ–e>¹ä¶\rKM7'Ð*\\^ëw6^MÒ’a„Ï>mvò>Œät á4Â	õúç¸ÝjÍûÞ	ÓL‹Ôw;iñËy›`N-1¬B9{Åmi²Õ¼&½@€Âvœl±”ÝçH¥S\$Ñc/ß:4;¾õ¡C ò80r`6° Â²Zd4ŒŽúØa”ÍÀœÁŽƒ²ïã*ÊÁ­-Ê :Â˜ò¨¬Ìå:ÏÄ…-£°Ü\nó:9B°pè»#Ã+rå·«dn(!LŠ.79Ãc–¶AàÂ\r	ðÌ„CBl8aÐ^Žó\\Å«bô´áz—5	\0Üƒ\rãp^(¡ð’6ŽÌ&xÂ>Á:\rxÈ™\rá\0ê „˜¢&\r)Rò\rèÉŒ P¬¨ °Ä:®°ŠÔµc°Ò2ŽàUFÕ#û`·‰ÃËˆÅB¸Â9\rË`Î9¡´8Ä<¤\0HK_Xê&7ÉÏà*@ò–²Ïqûª#ªÈ¶\riõ¢Ç£0Â:Žpì·²(3B2*–S‹\0)Œ#l÷o•ÊäÀ§nðÐ;-èÚÌ¨£´E\0TÊ7!-L„)Û,’e©Èûd3±€PÉ5ïu6-zðŽc\$ÀÑáh×hcxÓ¸Ž·uUHŒRõtƒ™Uˆ(Ö5¬ˆ'¤l³œ9çyí3H\n‰žgÂ‚ÓS/+[;Ž#\0\"¥º«Ÿè0æ<ØY®“!‚¢çÔÝyMð\0Ê¦c`Z4'cËp,è%nŒÃ64ªÈc;{kYc}%VH¨æ:Œcú9Œ×9'Íác?Y6Ã\nØÂ¨”>k¡@æ¥\"¨Î<‹òäb˜¤#n~´j—CÈÙÖ˜0°hÈÏž6`Pª:IÜtCÍˆò„0iH¨4aÍÌÒQ~8‚2`èW,1Î(3€ÊR¤­,(¡|2N0}u>ÏéI†L\rnu¬6'cƒÚíƒsÍ]É²#žÃ\rË\0:’VTC-è´(r†üß¬…*­Ô°–ƒ¢\\KÉ1&DÌrhMIÈ2¦Ò–œ’tiÙ<'¢–Šb€.Š\rC‡¦@J)¾4¦ß“³VcrI*¾çà\0t'dØŒÓ†Á«h‡„2(x)^q™=ÁŒ™§@É¡é#\n ÅC2( ®1Ç7 äž+›Œ\n™E æ¼HÀc8°¼4–ãü\\K™LZÊ˜ù” Oqð1Šv%’	@P²\r\nò‚kAE%4€·~RË›ûp\r8‘x¸ñÐÛ\r-@2—8¬Á\rœ\rÁ¼çäœËë¥tî¥ã¤gŠZÍ	lŒ¤yv¼VSÉy12HýŽ†b~½OyL\rèÂ)—×zþ\n[û=äû’DCËy HPK6†íãªœ'ÁÅrž€ÌŒó×{2tÌ”ÀÆ“”b„S,¹”ƒHGÍ#bOlPŒ—tÑžh /„ (`nrÅà¡ÍÂtO	ñô)‘\\û2dâIƒ:¡˜t¿çã*ÞiŽ ¬ÉÂ<MÉ\$.”\0€¨à˜I0lyô`¨ŠEO\rZ—IÞ”èj0)e!mF`Ü¾L \nGh¡]3ðœ¨P*Z¬ E	®¬u’’æŠ8Vñá#Tn(‚æ-Ë¢¸8\$'NŽ‰ ]!²!G^ëéB¡ž+‡….Î1S‰ ’–‘c\$¹z1cÎÁ €ªhŸ©kÍÚÛkÍŠÈ\$&œÚU˜DõÈ´—j¢Ñú WæjLPt U2S’JJHR0Q\\	s9Îå[{€Þ1å@ïF\"p*%U\n…ÚŠ\"Ò’¤OMW6'…tÎ¡ÕÆÐ`2!Qôó]…©•BšTê¦éªóc	kWffüPÒ&IØ¨M4Å½Uœ‰Zo[‰%©¥ö§‹‡˜[Â¡ipEHÜàzîgËRIÉBò8RØy|qk…®’ÐdXRZÐ}U6Æ\nÒ™½=HÌëUÀ¨BH²õŸÓÜjç4k\$mX2€ÊIÈÉ¾?°žÞ°Á\0/*ù@ÅE„¡ò©€	rÙE@ÍŽpO	n[*¸\0i•0r!0å¶:µ²ù<Ì9Î«7¿™Å.iÍsxÄÆN¼™M4ùÂ8¡K3~^Ì\0ƒ1ì®4E:Ð™ËF²RÃT>DÉ”çO\0î¯\nJN\$dtÕ]CLu!31ªWrkfÂ1Š ¤)+PÊªI\n§\"àiˆ||Oý1yô’ärÞÚK{Ø¤‹\"rÐ©ÖY;&--£\0ª_È¶HAHÅ—B‡få)Û”FNWààÍP){1pço û†EžuÔ6;x€î™fï­)…\rÛ™mâ«÷¦æhT§|›ÜÁ¥¡dE(üÔ«pÈŒò\r¼'Ø†#“~T&)CCÈW‹0çÆN·ãwƒžDx©Î±q¿§×~3;7Ê®zÍ¬Ò”Œ†&cH\n	Õ¦Ç¤™dÏM–hvf”óÙ.•¹%4ÆôÉ£c¬ÿG(tÇÙ¾Àwí)aŽíÞíþ‰fúÝ9ÝM®ïrSØL] =fÍæâßŠµWÒfÿ2eŒÍóÓÍ=Á3o²ÜÃ§uÎÅ¼œÕJu‹=©Ëä„›-Ë½¬ÕLñX3Æþ±Ë¼’òò˜;Æð©¸{n\0mõA`:=YÊN4ï@‚¯b­ŠÍrÑÒšx †JL-—÷<{VäÉýEôˆú¯ãˆ·J‘>4X'ÕÒŸ‰óA“àòU€Õqxg»`ŸÍ/’¨íF¡VYµ7ø»õëêNùþ??Ù±Œå¯·ÁT„\\]À|…)þÐ¿ËþRRÿd˜óÎÊò/¶(L\\k‹D0€Ë\0ë`Væ\n`ØZÆ	\rj<…r#bÎ*2Q‚î\\c¬ï„–ñïÖÚÌW.ZÿÐHî.üàO@ÿëör&ãäã\0¨\0ž‚†ìHKBhBJ]pdFðvkÃ¶µû-¬0eB@Ä0\"œmŽ¤ýP[	€×	Ð00P¦„ïúßÐh(0²Mð½	Å–Y°E\n%˜A\rÊýðÀ¥ZæP‚0”HL\"Ã\"¥oòß\$8ð¶à÷ð×\0oô¿dÃ­#¬&:À¨B†,vé,HDd!0 þ'ð¹â\rŠRbàæ3,S¤„ê•IXjQ¤ÃØn+aì¡kR‘+1Nõðlqâ†=ñfþ\0–Y%zQ	˜`@‚Ñv`LÊŠÌÐðÌöÑì² /\nðë6d\0\r€V\rcÌ!z.Ž  Èn‡oÈ¨§‚Ô(f‰è¢ ª°\n€Œà•¦PÅt%1ŽÜ Ò¨c~Ý1˜Û®ÖÕ‘èEÚ¥­Zy\"ækãe\0°ŽÔŽ@CŠÛ<OŽ8Ítæèl4ƒ†ë#X\"Ã]j–0)*ªKV:cÐAŠS<`¦\0#”\\b0e–ÞCd²N’²¥\"– ìdñêßX>®&oÈà’n5ÒrèM \$NQ&Î\0005Î½\r~(K)(BD&c\"<Ê(ËªôèW€¦›†ÄÉ/²Þc¬	©h-S ¾æ#,­bTï`S-Æ]è”ˆ¥Ðh -Â 0\0‚-ªø¿À¦g‚èZq‡&†ÊùL2PB´†o0ÈXààå¥\n‘B€æO&F\n†-h˜Bd*\"àÒ";break;case"pl":$f="C=D£)Ìèeb¦Ä)ÜÒe7ÁBQpÌÌ 9‚Šæs‘„Ý…›\r&³¨€Äyb âù”Úob¯\$Gs(¸M0šÎg“i„Øn0ˆ!ÆSa®`›b!ä29)ÒV%9¦Å	®Y 4Á¥°I°€0Œ†cA¨Øn8‚ŽX1”b2ž„£i¦<\n!GjÇC\rÀÙ6\"™'C©¨D7™8kÌä@r2ÑŽFFÌï6ÆÕŽ§éÞZÅB’³.Æj4ˆ æ­UöˆiŒ'\nÍÊév7v;=¨ƒSF7&ã®A¥<éØ‰ÞÐçrÔèñZÊ–pÜók'“¼z\n*œÎº\0Q+—5Æ&(yÈô\n(üþXƒÆ¼<Ò`zSq”Î•®OôçŒ¯rBA ©ª¨îß+Hz¸\nŒŠ7¦ ò8 O»£3ÉÂ	Ã¨Û¹#ÓúÃŒ+ã|cÐÂŒˆCJ€9Ebš¤B8Ê7Äã ä»Bb²áB“5ƒÂ€Bœ\nšOcÃûÒ\$FiHÞ¼IêÜŒcCv6\rã;Œ9.[š0®®ZøÖh(Õ7ŠÐÈÁèD4ƒ à9‡Ax^;ÑpÂ2.¯èä\rãÎŽ`^28Ý6\rãp^*ód4´ª\\ˆ0ƒPxŒ!ðA ±/ª /°ì®ý\nbŒŒƒªcxÖ0¦-<·\nrê5°ˆëZ¿6Òë¡p(æ†YäÝg!í–¢MÂt02È1Äl3£!(È“1c u]ƒS…wÝruäÊŽàP–7‘2\rÔT\\¯x‚:©Á\0’7l„NàÜƒ’œ„¿MÚ”iüF8WÖxÃ¨Ü5´ëp‚Ž?ÃK(V;ã ô‡¨Ãb†ôŠtR'£`Ë;£¿#.££”Ž¯þ(¥ éÓ Ü£Ç‚ºx0Œê\n”¿¯úuþ¦î£ê\nùf9¬¼2„È˜\rã îÊ½ÀTdç=öÅ¡'O¬ÆäÌÛÕ´9Ì©tZðn[¢åÂ\r6Œ)ð©èév 6É3\n¬àÃ¢³í+Ž‘µ|BMKB*uŽb\\FæY½ÖØÙ7o“=À0â£Èðìàôÿvd+¦\r’Ê‚ èH@7ŒÃ2Dþ¦Ú´Ñ50Í“Dû¥ihë¿Ìºû*1œ0ï!b0Î{î69±¥«šƒxQ¸C–>°Éì*ã/·Ûû¿Afød.Ï™i‡'ÒkZY\$É.·âpŸ£öiî‡¼ÿß\ni|m–?àÄú”ì\nm1ø#fM‚qsD82%àî@Špk\"\0€!…0¤smƒÇ‡2ROÐfR!´:†Æ\nBáœz!æ\0‘âVÇ¹	'ä<›FfrÉ!bï¹ÏŸˆÛ\nŒFÈò˜ðÞŽêÁ3‡Í¾‰@žA{©õP0D|9BeUªÒl”ƒ˜j(0½¬ÃáQ“ÓMi¶7@˜”¹	‹SiqÅ.Èp@ÉJøk¤®BIPÃc„rŽŠA(E¢º‹Q¨H)%(¥”ÂšSŠz:ª Â©3U1õWx~ÃpÄª¼2”àÈ¬ƒ›æV§Øƒ9´ÚRˆ!,(34”“SÔOZÉ@?då†)Òfšv5!Ü\0	°TqªÐ1‡@Ò§Ji\r°“6Â¢rDë¬0†bˆÀuaŒ‚‡0Í`ÈgFÓÄ:AjÛšpmŒ4Òª‚ì™˜/Q™»ôÙ@PÅj,þ—:82ÚœÁ@ûòbLË³@n\$™„Œ\\í‘”™¾L'-MAP/æm¹3Fu„ÉØšÃ@Ów~ûMHbKàû;ã¹<™ü¦„nÓGâšÐ¤2Â°ÓIQ4rÍ²&¶R¦ƒYòF0…W“’vÏfÃ\$HÄ1PàeKø D:,ôF^915õ‡ra!æ«Ê5da!)Ò\\£«#¯™ÐÖGÍc	WÍN·»ù\r‹™'¨Ïâ\nÃ•œVì0oIÜL±2R «á¯‚4HÂtm–xn¯ €à`Òšˆí3\rW\r‘«|\nXk5-¹W“xAKw#‘\0¥M¤ê’¤HwÅÄ`©K/ëFRáA²I°K_´ânÐBÔ¤dÑÜmeÌ ·HÚù\n,’2êíÈÖCx’–ÆE#D	É<îÜEø¿Ö\rirÑ%ŒÑÄIj‚ðàÊÌAÓšU ì£ãi¡œº&ì^Aq‰B4FT”žÄy+%ü'ÅÆwµ7(@­j`r¶ä=2øJPéâ#éÊk5cØK•=ÐU×8§(ßŸâfHÓ5¯†úÝ#z¸K¾B2Ö”‚°è%YÀÈ¡™©ñPLði²)Q³¡	ð´M”2b|/Á–71!_ã,…\rs>¹Å£4¼J«ÛyIå¹¢³ÃŒQ\$*3µž'ã‰²ÎE¨‹†œšÙÒÒZ‡îŸ\rddu¢#\nšE°°È…Ó‚4(Û_“£t1EÌu¡/„2ˆlVyäÅ&.â_2ål©™êÃqœsµ!~ÛeG¼*^€ ˆÏ=!H¸Ä\\ÚÈ\"‡>9˜Ò‡Pä@Mdl­«ª>‘\"ÃÛØ©:¯ÛI|l € …@¨BH#ø–‡u¦{V˜¦Ï7vÔGÃ©]`¼¯/Â¤C\"ô1æG”žUÉÌži6||Bó€°âDQc\$¶Î\\ŠS×_0G™ð®jy½%Šb)†^zCÈýtäÜ°É‡žˆ‡:3læÊwœt¸¥Ï07Pçð7•®%ñ\nHc4Rs¤uÊÝ¢9×M(]´ deáÇºËô\n	¦>Þ·Ýzîë“½wÎ¿ÑúOï\0BD¾naš ir}\nÿÝ·Ú¥Ja#—ëË•Z©Wœ/ãzvk¢0”ã!ðAªÎïz„x•\r	“y‚HnÒ'¦²rUl0(b¦Âeûè…~°NE%A³‚BGR)«#0	ƒ‡‡<<k¤[·bâ.y;sÌÌœº²Iê—«ò—Ü²©>ÕÕh›~Qh‚ímþtëÏÆš‰,ÁÌ¦¶©>Òü(,›\0çÎ¸ÿ°ÿìŸ\0&äR,š(PÂ†ÌÒ#`l(~4h¾b+lÂ.Öî-<ÊI„?B \"@ \\£„4è’mcáƒ’ „ICN6\0¯‚ŽÂ'J\rÍŠ'p Üë/‡ `},ä%ö_ Ú›@P­Di`S¬6ÉGlrð†‡ïÍ\0bùì6Èê~{°0ìPÆ‚ÐÊÜâ‚a=ÐÒDÃ\rp¶’Ãns°ÒrrPï©‚w¤[ðá‹,çxrpÚýÐòê#r&Àªö\$ÊHà®MêYQ\0001(öbêëŽŸNìè/ÖïQ0~ñ4ÿ0ß¤€È©ÏèN¬-æ ‘QT>ÑYâ1!/ÖìåôÚËê²ïóÐ¾1ˆÛ\0ÃOÒ¾JÚàÄ¦q\rpå*BÙ#*ÙŒ*:-èM*f¥ü((ˆ>‰†\$ãô æ¼¢\$NkÃ„-gÌc‚% ÜB\0è%£ôØ„,šNÖ ‘Ägì-	ÇÚR\$žUâØo©†Hñô·pO„\n\"•ñ¤F1‹\0ÂˆLQÂ|m [!àm©žÆÍnZ¬+pÏP\n\nJ×0ï\rì¥2W%«õ%ãí+\0 ªq'`.IîZmpZÃ˜ß¦\n§0î%p,ª-ü©èÿ\$Ò—)²r‘'\nÄÕ-¢ÆR™(¢ZË²zîr©+îöF)„i¦% Æ=C€8Æ„Ô&ØWãÄ÷’ºßæ´‰äŸå½ÎC±3­íéòmñ]0‘lÞÓÒo2s+R<\rôd‹i#¥ sDÝ'g^v3*rÀv35%®ë’vãTCd¢2\"haŒå%óZ\rs^4ó\rÓ-6³o61s1ÒØOO6Ò%2ó<ËÄë8Ó`MÀ¨Cq\r&1“	77q²ý3‰3F.S´jÍÅ\"Ó«)3§;ÃºÛƒmó…SÈ'ÍÇó!30[MÃ<­Ç;nç;ãÞ f=RÆ;àªtD\$s¢üëjý3þ?D\"­:³Ó@Ô\0àðþ:GnÕ Â\rföfÈ-ÒýãÀ…qìH>[C63´>DlnÜÑF(RÎ21L£ÆÈð ï,ë¥E¤¦µáF!\nt1„ƒ6*£\näLt<EŸô\\\r2è88;ìÔìn¦\\H#ÉTŸ\rRòƒ,&À†H@Ø`Ö*«@(Pxii”\$â§Ã)Ãº)+â1+ÜžÔ}!Ø\$Ãò)BØ/‚¬Qü\n ¨ÀZmI®QëÖtæ\$þŽ^ýq›+.–õ	M3PîÌ2ÒŽ}ËÙP¬úL®Ðm‡öKÂ0§f8B:b¬Â¤ÆÎ5óã#íØÛiLô@àò5Ô\$£‘%iL“cê;µ\nihþ²¥þü‘óO¬Niâ9j5Œ¸\nõ‡I\"Ü…ì®v., /¼;ív/ÈFÿ\"\rçü’,ŠšÕª(•¯\0¼bZ–u¼Ò5ÃQB0(ÃhƒuÏZÐîÊ4W’0gÕâü`à8Fzþt3ÕÀEò~Öc¸7F¬9æ\\÷Ž´û•¦{µJÛ„Ì\n`×´ÚI(ÎÀê\0Ë„”6åË	0‚¿åø¤¥ž\rG-ÄŒ¯‚ƒJÅòú¢ÒÌM_Oäe£\"€\$V`J(V…¡u¨VÄµ¶‹AHŠryJ¢FÃúI¤žÉÃh>f6”~JS˜ed¸ŸHB»`ÚÄª~\r¤`FDØ-ÂZ";break;case"pt":$f="T2›DŒÊr:OFø(J.™„0Q9†£7ˆj‘ÀÞs9°Õ§c)°@e7&‚2f4˜ÍSIÈÞ.&Ó	¸Ñ6°Ô'ƒI¶2d—ÌfsXÌl@%9§jTÒl 7Eã&Z!Î8†Ìh5\rÇQØÂz4›ÁFó‘¤Îi7M‘ZÔž»	&))„ç8&›Ì†™ŽX\n\$›Žpy­ò1~4× \"‘–ï^Î&ó¨€Ða’V#'¬¨Ùž2œÄHÉÔàd0ÂvfŒÎÏ¯œÎ²ÍÁÈÂâK\$ðSy¸éxáË`†\\[\rOZãôx¼»ÆNë-Ò&À¢ž¢ðgM”[Æ<“‹7ÏESž<¡tµƒ®L@:§pÙ+ˆK\$a–­ŠžÃJ¢d«##R„Ì3IÀ†0Œ‰ Âœ(óe¦pÒ¤6C‚JÚ¹ïZ¤8È±t6 èø\"7.›LºCbð¡.«¤ê®8ÊøŒ¯V	ŒËŠ1-¢[„2ÀR£q<ˆ:U\"²\$ªÿÅ#LVºK)ôs)Ëò¼d\"¹Ã“& +¤Äå ŒœÌˆ ÐÎŒÁèD4ƒ à9‡Ax^;Ñt06¯8\\ºázQI0æ¸ÁxD¨ÂHÚ85ñƒœã}„€èŸŒ›jÿ\nbŒ’¯Ë-xÇL9ST˜¼NSbñ£ ë7LKÆ¹IR½\rØÌbc_+Ã•ƒaÃbpÞ;#1û>ÚBºY\rÃ:(Õ£ò„7 As!( †7ƒªó#ÀUßQ‘ââÈ\rÃ;|#\"\r‚ø¨NxÆ¹ƒ+ô:ƒ @·^2¦’Œµ»šÇˆ×“­6 P‚êºðJ((&Ã¨ã.Ù” á\0Ø7±ËØž9C+ËßÍŠçH2M„§)ÚzŸÀHÊJ®B6ŒA¸bLÁMz&Ç\r×³âž©b&L¾îÔÞÅYÌr[)?Ò…ubì–BZØå†ºÚŒ6\"Ž{´¿´JÒ´1dƒK\\®ñ•<!xŠ<q¹¥in ÂCÑµoè ˆ!=;Èê€Ãlí·a®3FÒ¥’ Þ3ÏXÜ2§\0åFfÈ›bé‚ Þ '£ËþÉ£Øf\\7®ìXÙŽ]ðÂ3Œ+ÀAé]]¥‚2…˜SØãZPb˜¤#ziJ„õ©pA6%NR^º\r¸bX¸µKuñØK)ú„öokpssx.Ü›““NƒY²ÇñK®@ÇÝ¡ylÉ\"6ZžM2|OÅ@â^NzáTŠ˜œ17ôeÊàp&¨`0¼·~OÛoM­õúÀPšaŸá0ÁÌ;—E[\nI©Ô}Pa=°¤ü „PÊ ;¨ ÉC’JEI RP¥ÎjšSŽP’€éÕ9PU)V*åR^óÓaÈ™Ù“Ø¼N	²2oé‘%RH@•út9å¹Bf@ÃÏ9 €;†ØIŒ! ð-ÙB¡ÌxNÝâ’f^òd iUfí*T`ALë59åéc.œV@í0'€Ð€\"/ÊYŽ  6ÅÐÁK PTI'+ÈLÅ‡2<ˆ‰ lBÇ5×ÈÏc‚ÆÁV¸ÓdoCpoaÅé—‡x„d%e-,Œ—€ìùÑa'DáœéÒ”\n	C(²Å*å>GäSý9è¿c‰Q÷%§él\$’¡P'\$‰“H€‘ªaÉÙVª³zgYa^?\$ØAä‰˜n ¬¼ÿQdJóßÀP	áL* \$j•Iâ—oà€3¦àÜ†_R?Ô…’ã|O	ñ¡á†ƒ³ÂDì{ž‡07Â›§\"4T=ªõ@ÐÅGEÙ­+#ó4Øy+*K–°ôç¹Tlø»`äI\"Šö4ä‘-zÊ±†LC›•0‚xNT(@‚-€°A\"„À‹bìŸõñy-T¼”,b‰U2uP	ý€m‘1ãÅ©¬bÌ¢fÙ\\!Òn ³Î×²ÐàK#–\r!á'à›âis/–sŠÑ:®SCíú~SØ^P%b– å\\0–…Õr÷1\$•–—Íc0€„P+?2„IË—¥È+wpFJ€:Uå7NqR‡Îš•Šåö[Ë’ ’µ3`åù_ð‚°‹ÒsqëÂqwr`Ì)\ni‰ ¯pàõÕ«!!#òoÛÃzœÓ¡ô¬Sre0Hz‘Ä¨2‡pŒË*ÁMÂÄ60Äm7&,uf¶â4+qÓÃ°Ö¼Ôf¯ËÁrÇ«<ã1òb®	hC®iQ_Ójñ\nÉÎD¯ÈŠdë¨ä²ÑA@ƒÔ¼Ë‹Àk<“ŒV›„ü\rÉrd—ˆÅ°(I!ÎFHÒì7BZ°d2sK–*†,.¨)ÔÑ)tlß¡È«—š™\0˜j]@¼°®§D’ƒzéUº|Ð.ã›¦~b«<½<gµH­ü\0•Þð4ÎªdÒö”ýG¬5.²½r–W \0Ö\r]¸×Z²¸®¨)ª¨q\$ÅsUëÃ™¥5›÷Ö»;S°Ä–Dö–Ë×†Éƒíƒ¶HxÚ¦=ŸI£8Ã¹pòðåÒ–x÷›‰ª)C{!–}jQ¸'Œä¶™v÷(ü-\"3ñ7ƒÝ;®•R™˜íÃo F89”|©¥2R¼MÄ·Ž¿rOÈ HIV¬º°|\0§ÜQ‹›rìhIÏ[´ÖœÕÑª–Ú³ñ*ÚÔˆî™LJN±©Óç/úätƒÏ–?@é¸CJWÀ¬‹~7Ý\$d‹ËÑtAF± ?Ît–!6,†Ù’“Ø¹-qc·ÚF:µ¬‘íÇ>rv^gH¦8È((£u@§Çþ½¯*Fçha¼õ›’ÚnâéwBä]o2g	BD…„ãÏRéø¿º¿»~š|xYÅÖ1Ÿ@7;³À_bè:·;öè×,ŒK”š×§jk½[¯½=!›Y¾m·uÏÅÕ†ãWk÷Fl¾_Í45ÈÔeJì¸kÏ8¹þîœ«]ÿ½êH[)Ì%{ø!_¹ëÄæ/órÉvD{íô¯d˜ì3c¼h¨ÆbŒ6d:\rç–C/Ì/âj?â\$O\$èf mÈñÏîM,›#–#-Hæäø âPVêgL©ŠâøÌûì®XŽœê¦Õ.BðÃËÌ þ«*Åä” ÔðëÆ¾öŽ˜'|Õ/Pü‹²%¥”0CÒÏ.o öÐ˜(~ðð ‹Â3¬JÉfÌ}p¢^Ìý¬_‚DbÄ(¥ì…ŒÆð´N®>%@ÖcŒÎiü(°¬üOj'ä:èÏN õè,ë°°†Ð¦9F2+,)ÄîFKFÇ\"?&51 9KÃq\nKæ ? tO\0ã¤²e!†Eú¬Pœü†'‘MOä¹V±Kðu®±C”2qY‘*ä€ËpD\"‘4#ÐìÈp®n³§%\0ñ{\0Åê\nŒÂmï6çq¤.Ì·¯}ñ¦þQ	B[àÎËkLîkQÈ 	ï	pÂ\n¤ÂLq¨ülKÍ´è„Toâ[bp	\r:›CÚjÅúHŒpðô8ÅÕè6lËÍ¶š±\$	ðìÑŒA€†eæl!Å[Ch0BöíÃ]I43o²½r&H®ØG2BÃÄ\r€VcÖe†!Dã Ä3ª}®äÙPô0@Zeâ¦¬â£Iz@ª\n€Œ qF1eÂ'\r^ç¢Šq­hÔO’Ô	®­-†'	L)¢8CÅ.™'lVÐj ZY†Ú.jÆÎì\"v1ñôÂŠ|uÀ×ð¶¶ëd/Gø%ð(G’Æáta¢Š.@˜«Z(Òx7•1\$0<àð\r¼ÀPÜ5å¹-cdXú…ƒdò%¥3¢{f<6S4?\$p L>(ú7äý£{æ…I¾þ‡&ÆÈ51Šó“Zj3^û¥Ö§¾\ràà9åÅ@Èv.¨0Ã—	*ôÌ‡<3%r¸p/3FØëë>òk„K²¨\$¿NH&ð¶ã¬#\$’Ã:ç’¸ìL@8Ìf\"ócŒ½¢êmÎk/ƒEälËj<‚¶OJmc·åÞÝ1g&<¯\nnÆá\0FëdC20ó†ºäp";break;case"pt-br":$f="V7˜Øj¡ÐÊmÌ§(1èÂ?	EÃ30€æ\n'0Ôfñ\rR 8Îg6´ìe6¦ã±¤ÂrG%ç©¤ìoŠ†i„ÜhŽXjÁ¤Û2LŽSI´pá6šN†šLv>%9§\$\\Ön 7F£†Z)Î\r9†Ìh5\rÇQØÂz4›ÁFó‘¤Îi7M‘‹ªË„&)A„ç9\"™*RðQ\$Üs…šNXHÞÓfƒˆF[ý˜å\"œ–MçQ Ã'°S¯²ÓfÊs‚Ç§!†\r4gà¸½¬ä§‚»føæÎLªo7TÍÇY|«%Š7RA\\¾i”A€Ì_f³¦Ÿ·¯ÀÁDIA—›\$äóÐQTç”(_mèêÌªz7­ÂÈƒ2æjÛ„\nÂ¶®©¡\0Ô¡³Ír!Œ#\"V0§CJBÜCC3\0ª\$IPÝcª†¾¯HÉt6¡iÖß.r€9C‚¯ P¤2Ã@PŽ2¾orû	Œû‹ŠrR\nhZZ¤³o´TPÅŽÚV×BïCP\$3®ŒpÍ‰ƒzþ7DÃ’z7%h0F£CF3¡Ð:ƒ€æáxïA…ÐÊ£8Arø3…é]<Ašò7á°	#hàÚÆˆxŒ!ôÜF¢€270\0)Š2JÏ-6£&ê·ªJ.&¤O+ªÛ¼£¨è:Ç\0P‚6 Ó8@–¤ˆÝ…b!uÛM_Xàœ7«ñûJò¯Bº^7=(¸KTCÊÛáÂƒ\"âÞ6¬:WU::G‹Ó,1´wš8 ×Ïš†©ŒkÓØþ¶%ŽÁ£-`2ÖNƒ(#]¦O6ö%‰bˆ¸ ÓŒv‹6š0I¢\rˆ	ã”4À³pÕðÛ¡NŽ\$ª3’w7¨#¼ƒRÐƒŒYX€Ø”±Cj‹iõâù§Ê­X&L[Ä>îc)aØ®¬½\0L5¬e¬Y©ƒo‘>‚±{\$8\"í8L0ësÁ1ãM˜Ò6#ËüeL¤(c(\"ëßxìî6Cƒ¿LU³Ö![fÕª=¸nXXŒÛTÖ%îðÞ3Ãc\0002¸Ã4\rê\n|<À,¸ê1¡IÍ‚ä“SÀ £—X0Œý4ØÀAµE_¡@æ§\" Þ5¥a\0†)ŠB3¾–(}’*Zê£ƒ2ø6à©zòØ®×ŸHó¤­íÌÐÅ(S\$Þù-pÜ5·ò`ÿ½!\0‚2Pè_pÀL¹TdiÐÖ§tòV>)&éu>¨N1·Y%À™¤2]Ã}?gô˜2PÎÂAj\0\rËPž'ÎLrÅ\$89‡røª p3Iì@DìSÂzO‰ù@(%¡‰Qj5J rV¤Ž‚•RíñN'¨ŠÀ TªT“×˜wÃ¢mMéÄã²øoÑ©˜\$lexuMpbnæMë“ Ðwƒc*g@vîJLbm~ÈÁTÍ\nŸk±nÌ”Áç•1À;ÇÝ“FÊÊ™‚1æpŽ„) 	Ð#	m#T\na”Œd\n (h¼ß¤ø(+\0¤•d(dƒ™![„œ6!s œ#“ù†È›7slª¸8PŽ,˜&Já¡•’¥4–€G\0vz¥P0“¢uŒÔL%¢i<wšJšD¥=7\$HƒÃîœï`ü“øMÉ€a@P™Q“’ECÉ«@…PØÅ“0vNÂ4lˆ³³NBÛý&\n™æ†6J€1Âñó…\0žÂ¢b1Lèž©\$Æ:8;.#ðÈHq18làŽO©äùž†eL»8È\0ˆ ú8™óÔ9²O\n›\rèf˜®büyû—Ë—\0Œ%+M;óˆ†EŠ|È²R!h\\×ti‰ðg°X‹°†o”›(	À€*…\0ˆB E­@€\"P˜k‰H©ˆç®ÅÜ´äja\n¼aŠ%Jy™¹>( 81„EßØirÇT8rŠQÀR¸\$óÅYK4ÈÌ[¦é”{6—\\[]nNi\n­5V n.1¯?PÞiw¯Á…Ù2alíSŽlÄºßÚ–æã’If›äŽA\$dŸC\$æ}ÈÜ£´ˆ\\T`éQÓu4…J F²bíJ9JV\0Ri·dq€”{¹z\n¿0A¤‡µÔâ&y:1f5&_F¼ƒƒÄ·¤2,+tßÛjOµ“N6Â…ŠKzH02‡pŒùb¿N1vl“l’âbÊíb\r§­^|³;²JÌ˜:ºw›bº\rÕŠ¬SXƒ•2VùÜ—ì€‚P'ÉÅ’\0Öúi½Aï›ëHÎ‘Žr\$œè£ ˆÝ%Ä­ˆ¥z¬ ¨C	\0‘Ôçgì¦\nd„PäiË5€¥b!ÅÊËJå4k\\Ó®EQ ÒQ§]'C>Q²ÈÃôwÒh’drcÀ%u:ìúa´Š7ºOCéSL‰cö™VÄä'IÂ{ZiN%÷Œ<j^NW.{`´m´’Çuz/†ŒÅ>m7®tf»1ÄX8ëík° ¹¸`9ßLìg#³ôŠh(ÅHÑðîEÛä_:¤Ì¯/j¨b©ÚaÜ…5s‰ö	[…d0Í B8xR™|XH@¯•]ð‰	„ÈJkëb`W\na7ÉÍ±jóRñ<Êâ°\0æ‘Y‘*ÎèÈ\$\$¡†,Ëë½%‰™³#·&3(¤º™l»nÎ®¢'©kin]n\rñÔÂ:kšrÃO^õ¸<f6„@Nðç7%N‰CÁ}åÒoJ0MfÞtn â:Rø%ÖòÀ77c@QG—fnè2SFn(˜dLdõšpà¨È…ƒÞ™¾ð½éc˜¯]¯È©ßžÊ_¨O7{ ÇìO)Ž0n%q:+|+K¯ÈÔl[ÁMzFÆà\\tKÐmË¼éÞrã8ß?ËÍ#F£yßMm­ÇZõ–ËÒÛ^¥â­àO{8%ú\0ÃãoºrM¹úeð}ÛjöýS™ãbxe–X0Ó[j7‚h¹ö—ÕDàý³¨6‡ÖÒšTiŽe\$ú7Î6æ‘cÄqÔ¾°ý8ßÝã¯ÝñySY½UçOØ¬*ÆýïŒHîªÚEÖ]­–L\"ø/ÇšnBÌÅÈÊ}†F*¤`bŽ ¯w4ŒÃÞ¤ñï\n%DÌŽòmÚgP„cœ#Ôï°ÓRVJ?n#¥^/ü¬w\0\$8êë–CPR/Ep2Išjì†ÆŠûbÃ´÷Ïpþ@A	ƒ\n÷ÏâÞP¤3°ëk`¸cªY4øL¸—oàôO°Â{¯ò÷gã\rc\0Žgi˜²C«ÐÚÌ0ëã*,!Za¬¦(Åâ‚å„½ƒæSm2&*6ä¤jêJúCkw\n¼úo–ÿq%Ïñ\rð´+oÆ\"be”Äk(¹£\$_PñÂÃõ‘‚à¨ñ§.ÎÌqˆ/ˆF¶\$¢&‚\rÐegdTQ|©°³ Ë‘‰ðœêåª³QŠC‘Y1‡nU\"C‘PÜ‘Î¶æqD¡oð0^t\nŒ~dp©ÖèñÖÐÒù‚s1âë0á†²&ÔÈÂÆL‰ ÎÈà¨ åáÌºåD¬^±¹òKÇ¯÷!ÌÉ\"¾øîf	\r}—ÄæøHN\\«* +œéEŠé§®ÐË™%Fôäp1\" úmV^&JråËIv1CîC(\\¢¤4/|üÍ5%Ò†2î]&jc(ÒncÊ\r€V¡ÀÒdB,\ràÄ4jUƒôä«Æ:àÂ¦J' Œ©gÀ ¨òx\0ª\n€Œ qF2Lv×\rJüŽ”äÅ%¯ÆÒËm)’ð•P’‚¬\$DRIh«%c	kË2\rðˆ\$|1®ð\"òHp`ª*l\"sÌš~c¬2qÖh¥1Ðæi&Ð7ò¹à (dÖÃ¡tX‚Œ/DÒ¨‚+Cz1KÒ¨rä=NÎÙBª½±—e„7}/¯W±|Ú\"·8Köqˆ!Lš‰&éj7è1Š\rèd™ ƒ9L99®–Ûc@§’8„: Êy³°*b¢Â@É<sº9Ð¤±äº?óHõìó;‹ù1®Æ¿JX¶ŒÀ±\"~ñÌJÈfmŠ&bB8I ì4s\"ü‚.º:@FQ=KèjãçnÈ30Š3d+Ã7EÛ4“³mæF£Èýï\\¶´GåÔ!Q{K ¬C²CŽŒFé¿%rlC‡x/€Â";break;case"ro":$f="S:›Ž†VBlÒ 9šLçS¡ˆƒÁBQpÌÍŽ¢	´@p:\$\"¸Üc‡œŒf˜ÒÈLšL§#©²>e„LÎÓ1p(/˜Ìæ¢i„ðiL†ÓIÌ@-	NdùéÆe9%´	‘È@n™hõ˜|ôX\nFC1 Ôl7AFsy°o9B&ã\rÙ†Ž7FÔ°É82`uøÙÎZ:LFSa–zE2`xHx(’n9ÌÌ¹Äg’IŽf;ÌÌÓ=,›ãfƒî¾oÞNÆœ©ž° :n§N,èh¦ð2YYéNû;Ò¹ÆÎê ˜AÌføìë×2ær'-KŸ£ë û!†{Ðù:<íÙ¸Î\nd& g-ð(˜¤0`P‚ÞŒ©òê7¡(*€°ËØ@†\r¨{‚0¼Œ¨@± m\0ÒƒªIê~ì¨I²Ä¦ŽŽ»5)ëò4¦‹È@Ã„	Xä0ŒoÜ\n*\r)]\$-àÒÂ¸+ËMc\"1Ic²à)	í÷\nB’M¼¢8Ê7£(èÖ¿Ñ\$\n)ÌCk¤&rœG£d~Å/\0P¡\n.£!0Œ3Å@¬ü¾Î‰ƒxÏ\n'‚f¢Ã*Î‡‰`ÐòÁèD4ƒ à9‡Ax^;Ór”¦Q#\\¼á}SÊîá¤	#hàÊË¨xŒ!ò¢§K®8Þ28B\nb‹þ¹¬ Ë½èƒÄ¯R²šF¨dì&×ãJ\\”=O àòTSÆòÛÍ¶ë²,˜ØšKû@Ö+©ÀÜÙ3¢¼(7/c8æ‰Ø}˜:!-ûfA@P‡Œ#s;(`ÒåÅ\n\r#®ò&²X0¤2ãÎˆƒ(ÍŒ\rŠÐì¾Ž³•f:\"21ÁCL3¼”Éƒ!é\r»¯(é/Ãµo#W	N/ú˜:?ÈÎ¤4n0šŽ¹r­ 0.T6&×L,Õá.•Œ9(ä<çêÀÆägc›ÎèÜ¶ÐÓn0SÌ_= `VÛsÚ[8Ê¢âvkÔÜ5cFöÎŠ{Ò‹¸Ü(<`âÀ¢ƒtÞº^]XŽë:\"¨å¤o“Òå]@SÂîq|ù#ˆN—\r;4,®PôYŒØ£t @7ŒÃ4ÝD§¢J˜æb ÞÜQÌÐ£®9Žc2†6PO€XàlhåAØˆï a@æ§¢¦)Ö×El4ŒMà\\JÒúÍ'2ð¢ª°WÓß³Q‹NòŠÁ=\n†Ð7²œýŠðu!'Ø–^É›Ó;hhÃ•å{REHàÈwRùVêæ\$Ò†hHICdq¹”Xbž˜rPD ë‡c¯ÖY‘FdÀ¯0êOBha+\$ÌÄ æËÂÀ,AÁßàÊ‘RjUK©•6§TüTJ‘SåPªƒJ¬UÁÍX+%h¸¡º*E/…~°Okç}%iC%¸–L)_Y/†PÄÔIÀs:ä¹B—…ð²\0T'Ð:FÍá62dÜ9@„º°f?d!ä¼·šóÞŒ3A à8\"GIÁ¬<+ˆ4—ÐæOHÒˆp¶0 YbVYµ•¯´6uðÈ9¸C\n(„È†ÏXÙêIð0ÐÜ¢QªùŽ|4›´°Ðt)Ç%y•¢úô¼NMHYHÔÜÄ§#aÁ:ÂY.	Ã0‹FXTˆM	±E(äyUÞkQÙMr«â^H²Z‚&ô4¾ †¢ð_Ò3Ä\\<›\$^VÝ'!¹`s’y¸%°È@åA;èoAaÑâ;\rô@+„50 Â˜T–F-o´ÒŠyxT/-+rŠAÉ\nQ.˜Å¶¢7=Éyˆ¨Í^Ï„bw	qFh(2¸¨›4IÚ•à)Ú#ƒÕ˜o)P±ö†uˆ×Ér7d°#@ G(ãéVLö9Ò4¸NC‘;TLÁy†”H\n;s¹Bä‰`m[+m›„Ä”&OÙ¾flt°ÃåUÞƒ	«³B¡IP—Úƒ.	)¦ &XAšª1!Ô3yü·±@núN/°›n­±&9}Ÿ›2SÃŸqfŒÅ—¶F›ƒ!eNæe:WGÛö+'¬ýšªBz©ˆÎ·ëÃu9ÿ+\$±o¯â°eˆVbIÈ&|‰œzi¥H+·ý-&\$­@\$Wr¤€ŸÑ{Kæ*³_Ü_Õ”2aÁ	7æc5ŽFæIe\$yá n¡M“0È~Ñ3?®Á\$GÒIËÄ9ºQýÊÙÎxA»¡Ý*†Zz¸H7\n˜p»óc.ní¼ë—¼’N‘F•Â†ðàÝ¬žL4°9Œ[SÔÞ‰–\0±qeÎàÜLƒ7Ë–ÑtÏf\0(0ô­„æ„‚\nm“B:ñÖ;¨³J’Z0&Ge™„gîb“”2*á“\$ž²ó‰;-”çQÓ„Rv¾«uÐ‘ÏtÚ›Ò\n\nP „0Ø2)ÎÚàá6gGb‚dÑËÓÕo)c_€€‚\rw?š\nñ`+`/\\‚‹bxÅ‰e³`èôÞÖÅ âÉ.fß2Ap	Ù\$Ïe‡šdvyQØ†«c\"íªÛ‰\\ˆ–&8UujœQ8Ùg×µ®vîß1[g{ì [£wžÎ•/ýå™}½½Šahà‚uö»‘“p%È‚|.Ó\0·	R„%œL ¡YÓ<1yûÞLž±Òo`,>+ˆ†ÿ(nPš\\Æß|­#bGoOX©8À‚y\rj³–‚&­E{žëDÜgŠÉx•¬†ò\nåÏæ8-!w3HŒÏ\$,»Ekœ¡NIÅƒwVZnÛÐƒS3Ãyšº]UÈõ~5û-Û>ÏlHœˆPû\\³æwrmÞJ&YÝ=õuwŠvåVûHê*{DÒXºL¥©R7+ß+CgËÝQÆÌr%¤D°„ìslš×±ñâìïŽ'>–2äçUñ43Ôp±d”,Æ<9ZÜöRD%‡“½ªëeÌÐ°©”ºÏ³L9áE×tÝ#‹Ok³uÐå×îMâºþ\0òS=>‡Úú~Äþ³z%Ï¹ð;[tÝ,XÞØ¿êúÝ÷¸È|¿õþ=oõîŽê%2£¢/Ôà-ÀÏm<%¬Ú\rÆŸåâú‹¶÷m®ž€\0ù\0É’7+ÜÑ„gŽÎØ#\\»ÕMÒ2Ë«©ÞU\"føÐ ïC6úë¤k#÷ŽëPPÌPlýOË&Q/n+ÈúâÊb8}ƒ®F…”!ŠâòúBzpŠh=DF–k®F 5ÀÜ¡F:ä– ,^ÈîN±jÕ@Â°ÄÁPb°­åLÆ4¬†]BX5l¬ËØYËfËËA\rc:JÌ~aë?ïî±\\i¯\0þk¥`ÊÈÆÿnÍá|-:[¬}Œ‚fm,QF˜ OÿŽrúã.ÒñF\$Nÿq‘SM3®Ì)FjPqaÐ<TÓ&ú¼ÀË¤¼ì®ÄC¤Á†@ä;&'å–fã¦:¤L8nf_Ôfge­«¸4pa-Dgpü²Ñq¶þë˜ÆofVAE¯£Ô½±ÐFfú4‚[âÓ‹ÍFG\"†<‚E¢òeÁ„cBm.  ÂAw‘!!rr\"1Ôî²*Yr/#1ÉñÙ£Õ#²QNžr!ç?\$Ò.!òVG±LïqQ%…ÐG#n‡ñto˜ÊëË(6æ\\¨B³Qh»qN¬rŒÍîYØñR›)iïðˆäz’ŽM2‚sçå)ÄŒGdQBÓÄ@ªœÍ@/“Îù-Ô\n­*ý2ÒGÒå-¤c*à	„pLOñþ3  PçèönDmäÎÌ?e@Á‡µÉ_«³1³/ƒ20»Æz:%ÜX#\"&Æ‘3.YÑ]*%¢ÜP>Ü£-2“S.¢pÚ-È ^`Ä¾\r€V¥fÞ\rnN7žèe\n\\Bh…‡‰\$<rˆB´’d\n ¨ÀZ.ÆxíìX\0äŸÅ€}G6ßm†á“¸Ñ³¼ÜL–\":#âB\$gZ‡#úhxt)'¦ÈJÌ0C`<#4fï-8B>­C%Ïú÷ˆnvªjH\"†ã‚,„’`bzNf–/€&©o…­k\$ë#ŠNÔ7:ï&\râ´\\01EÙå”öó*ñšr÷¬ˆº¯pÿ€ÚàO	EiE¢´;h˜tôT2´XþRm3î2¢œ6ƒl2gÐÊÔ2ÃàÉG\$,Ie½Å¢H@†cV· 2©G&a)<ÏÄn´²;´Èt¯€e‚b:IØj€@MÃ&HÅÝ„¾MèžÀ	àáIåÃ\0bøÆã¢`â†PvBƒ:t_%&ì\$+‚0\"û5gFDÆè@ ›RJ`ô~vÄ’NÌä±%q²f:ì˜VB†ÞƒÈ Rú	\0t	 š@¦\n`";break;case"ru":$f="ÐI4QbŠ\r ²h-Z(KA{‚„¢á™˜@s4°˜\$hÐX4móEÑFyAg‚ÊÚ†Š\nQBKW2)RöA@Âapz\0]NKWRi›Ay-]Ê!Ð&‚æ	­èp¤CE#©¢êµyl²Ÿ\n@N'R)û‰\0”	Nd*;AEJ’K¤–©îF°žÇ\$ÐVŠ&…'AAæ0¤@\nFC1 Ôl7c+ü&\"IšIÐ·˜ü>Ä¹Œ¤¥K,q¡Ï´Í.ÄÈu’9¢ê †ì¼LÒ¾¢,&²NsDšM‘‘˜ÞÞe!_Ìé‹Z­ÕG*„r;i¬«9Xƒàpdû‘‘÷'ËŒ6ky«}÷VÍì\nêP¤¢†Ø»N’3\0\$¤,°:)ºfó(nB>ä\$e´\n›«mz”û¸ËËÃ!0<=›–”ÁìS<¡lP…*ôEÁióä¦–°;î´(P1 W¥j¡tæ¬EŒ£\$Â˜ìÂŠ’´ƒ1ÚU	,òTúè#ìâ¶‹#Äh‘Ò¾Š²äº”‹YvŽš±j 0Œ2ÏLZjÿ¹n;†™£+»èÎ f„˜‘IÐòA­ŽãPhîÒ‚¿£\$¥ÜÊï2^\$}\"¢9	¡°¬på1Ža I¡®BÏ<»TÑ¡\0;-ö\\SqlÚ¼ÈuzŠ¢-JL¼ËÊ¢F&O}&†ª5q?CÏV2¯«)ü56d+RüCˆÉ<ç%¯NÁ‘ïGQ8!\0Ð9£0z\r è8aÐ^Ž÷È\\0ŒƒhÒ7£\\7ŽC8^2Ø8ð:a˜Ò7á!ä¸·’¡‡xÂ%U[	.#˜X‚ï»‘#P5•aØ®LN\nbˆ˜4á‹ª\"Èñõ–äMk”éN	±\0˜¸Œ&ŽA×Ë2h”2Z[‘eG&0™,ðffý\rÛ´C ®¥å\\.½r:b¸Â9\r×øÎŒ£#V& Në»¯¯Öõ»l;ÆFƒ³vB»)¥ú2M/*~º‡·*ÊŒ’W§ènÕ?9ÏnDß©!ë•9kÉ.°9\\Þ±`ÊÉŠŸ&Óð\"hGH›{S‰Š|¥Êmhhr©|Æ½9]êie/5•rY%J‰ÀÕYÆi„¹=[Ñô™6eŽN½ÚÚš§º4Þ2Ÿ0B—ÓtU¹[k<¯Ðþ%}bØ÷T.~Äþ‘`Vjkj<è@‘’JbJ[Gi ¦#DJ…Î›Zk>7Æ4JŽ² FÑ¦”è(‹“£;Ša¦¦Î°\"ƒÂÁB§1ŠÒƒ%†\r~ýÜjSï_ô˜õˆÈ­8i-\0´qŒÉ‘°kïèþ\rÉ	MbÑ=pÍj€ ˆ¡i\rse:³Â°’`tIÛ)bÄËÑ¼RÆ	3¢¨”N*\"7‰Î”ç¤þ™{,((u>µ_²€eG5šB@‰T7€l¬˜ÇP_Ááe\nìî%–÷¡g,A‚à®£šah/FGˆô‰ŒJðlÚ¶³‘ œº©PXHˆl^d[¶cf%7”É\"OÆ‹›C2YÀ>B§&É°‹“Ò€íJ'ËÌyJÑîTÇèi+T°WÍiËi„eÑUJRù³É4y%KŒÅ)²i;¶c¸Gßrt@« ©bÆÂ˜RÀ¶A´å-–Ù‰€mXè˜\"rIHd\$%HÀ¯%âWˆmeq*¿fƒ&IŒj)†…rRŽ@a\rÁ¬9‚\0ÌÁ\0uaÁ¸3‚\0‚¿Wûdáˆ0àÈÀAè]K±w1 æðdb„:7&:ÇÓÂz–HjxŸt[\n\n\ns£h¦Žb¾.™<ÇVç¹qËóÖBDŽŠ­ÈGGŠB‡3Å¢\0“”³PuU+ÇDS¥Ö»Wzñ^kÕ{¯î¾éƒ\0`Lƒ0†Ãsb\0¾Ÿ1F,T\njOœRò£²<c\r#%dóA²ÅÇ<cCAÇri:Å¸IDy`žÂðÿ½2‚}+B•l¸6ÔHCAyÓ§ŸàH( !Ž¢±\0@ÃHl\r€€1\\àÀi8r\r¡•»ÌÃ‘¡Œ1†PæÃ0u¹a°7†uÿqÙÀhÐ4\\æn˜ k²›†êŠC`s.§Tò¤rN˜Pêd*³ºÙâbvjâJhjS:Ø¿ÓXEûùàPÐ±ôCõž›PP\\IGlA€\\FåzÃx È4‡k’C=ÔÅL:RPÓICpo—\nåðïu/Ù\r gAB,GðçÏ¢˜m,½B¬g2wJW?‹·¬\"P]T‘%3ÇÒ<ÎÆFô‰ë|eBz——>KE¼ÀN~QÄÙ…<¢œ“®@Jæ®.e°£W™¸”%\$ÎFD©LF)@£kLIËÊcE- J‰aØB\$›)%š^¿¬YÒ1\r=Héz–È+EF­Ž´LÂi3¥!¬I¢2:V‘„TZ@'…0©\0b¤¬›È0Ç9xô–}ÀŒö\r\\Åä%°kå*4AˆFPsY÷_¶¼ªHY%Y´‡“œ¸Ò”;Æ/&Èül¬Î.„d´Aé„Ü”›SAu*Mj¬‹«KÿŸ„ä¾“É\\0T\n\nTë®\\¥¢*œfÑ—§ZxÎÙCÚ(\rMDÂ|Íuº\":Þ+D3†c´\r•ÍT¢¼²œ–¯J¼–§ÈmÊVã¢Dü­?ÆþLUÜÔ™stq•^Ù+šu’Û8§‘ôk9eÀÐFfP‘ˆ‘#+.sÙ~cÓÈGhëZ[õUW–úÂ äg=-|©Žª¼(y¥´Å¯²–¦ºYå–Ú­;U+gf·³)Ú¤h¾Ô{rOîßÄ‚Y¼t~fCU`£¦Û @.ö©ßÔä¥—ðŽZu2éHE¬«„¹¦JP5˜H\nóÇMÏÎ#±rŒŠr:h=äpý7²yÀËô\\Fl Ù<Š¢¾X™Ê}%¯î'/€kUX€HœwAAû¨ç³Yì¶CßÂc¹Õ³0í†-HzÓ“Ü—Üf<û#¡†Õ>1ðå­dOµ>Iü³_Ê?qÍÞÂÈ\$'Ë@}oœ‚Fœù¢“*˜ˆmI/<âšW!Lžˆ\"kp\nkÄ|éŽÜ©ëpâÄ@*Äö·aO¯Ò(ò-º‚¥XË‚ôW©nËFTóíÈmàÑØÞO¦Œ*‡>×\"Äk\$Ò¡V&¢2­FÉ0xýÏ&8&”îªÆ!wH†ÜG~Ald¸UÅ\$î0~ðÅ¦éì˜X‚XÉÅY  ¨\n€‚`€-6‘cÐ£\\Pl,Wn@[Î8&ÂNâê[m†5ä\\HÒa¢\$nÀ^1æöÀÊ”\$þÔQ…ptÂ[ÆmN´L\næª²K4FÇP-!æØ™gNÒCŽÒ‘4ôBº+ñ<Ò±BïqH€O Qñ	¦­Ñ^!Ñ>‚dnFä¬’ðÞòÈ#¬Í§0,hÙL¢ÐŒì\$qDDÐùñxòL´ŒÑ¦b#¨ˆ¢ƒÜ“ÑQV(*¾*ˆÑ¢ö¢C³BI‡\rñCÑ¹h(u©6(1ÞŽ‘Æv±ðû§ÄÉ\$*R%Â` ÂX„ MCÔ\\dxëQ,\$'„&\"Y2ß¢F=ò\"â\"ëQ²€d`‚‰j@ò\$âEvÿÄÓ#OlöHÊ£%IÏ\"¦¥nh’6*¢D[NH÷ÐÀå-x)±\0pâîÕg:Jo\\p*/ƒ=Hx÷o¨ì|±ã„8Œ#‹p0n¥!L£‚Rš¦1\$Âë!%b0dPenVÿQ,²¿-ä¶ÍZDêþ&®}ê.ïöle¤{¢þï+ FòNqö7²ú*’þ²1g0Ròùhšÿ²ä´%Æ9ÙoÌ„Îm2Î”7ÿOÅ3“\nù§û+ÌÒuQ¬u„Øuåv'¾ŠÀä\rààd¢\"b£Z´ÎE˜ùå£7ç‚XçÓ6As*ÚOüYm®êÆ\0f·\0\0F[Q¼4ÓOì¥9Ã¸ÌSŽpÄÞ4|â@&Í3'dpå íîìñ©[/É€²Ç1ŽæŠOšó#11úxr	‡½/ã=|K°¯2NE2¤	0sÎÒ3æÎ³Ø=q@qòÈ‹(G=®ìäÓøWS)=%¤«Ê 6Ë0aCC”#A“¥“gnzÞˆ\"3.‚©83,=pàòƒ^Ü`dñÊ;Ù>¥¥A¨)1‰?ERç\"ÅEÔ	BKFF¨“b±FÑç-ë_GI§G‘†J©—H%T‰&c	””\$™\$qØ“ÙJ4G.*•.)°<ãN8óë01´Î(TÒL­¶P”ÛMóqôäZôÑ´ïß@sÒ.¨o\$&-„,4ÎG¤JÌ\$=	%DP•Š²y‰†£-¨LCã‡HÙ1»§MÑ¿\nîŸ\$Ê³Ã\\#ñ£ ˆ~ˆÅ¥Q\$*,\$à“dä}èN:Tçíî6˜/ž’µ8Õ‡¯Sã\nPåÂl˜ÿ¨;AÏ»œj(Ðþí.Ô(çô#±eAÑ‰PÕ²lØç¡Nï.§\\cŸ\\µ¹Ls&‰3,Ë[BïAÒIFu´þhe…Dsõá,UÓ^•ú¶õßEtÉ±Ù`”-U\rÓ`^4	J•¢ÂRtòÖG½^òÃcýaóÆ·’ÆÇÜb„ÖJ\$\$,j»ïªÌðSÌ%Y¯,@Hû¯ët‘F”t}3Ý]3g0–öy[´wL³àåöuK„g¶%C‘g!Ð¢ Çv‰Ã´|¥ZRƒiv‰IFËa´köª,yk67Ek¿!e¯Bäê‹ã\$,8'A„v\\QãƒW°\$J¬„Mv[t</6&}…Ão.Go‰ßoÌ Ì°`:W(÷gö^¶Fd—Œ‹p%[ô{-¶+\0ÂoqÏŠjõ{6þ=×pvÒ´BSuH	u—%s÷at7o•:×\niõë^Ccqq¤?-Òâëkv,C“vh—nâípZÛU»]£ózKzÒýtƒ{PDt\"õ{¢Ózõƒ7—L²hÂ›‚‹zu}ÐY|Ãšxl•`°±cP_sðÇs°%Pv{\"PÌ­WrXtõJB§|Wúfÿu×&E¿}-–.¡KN’³?c?iV‡Ft»;vàpÏ»,Â·'%MJÄ×±}±kKo+J¶#…‚`L1‰…í&òƒe.i¦Óq7†Ê*’øa‡d<.§#¦¼{P9ª¢áÉÓ&Ø‚úÁ¡…VaRM±,zÊt÷tµFæÖVQqGøg–‹Tœ!¬ñ j8hÄ\r€VRž…>hBƒbºÕ5Be4ì\$Ë6e'³Â´¸¿uM!s•n>RäëïROdÞ\n ¨Ÿ`q}n¡‰”‹wC©j“æ·“ç­ƒn}¦í†€&i—•.GV„:ÉØ‡•ùJW•{å7L¬“hvéõ\\ÉëYÓ9—ØI¤17aˆQ¬F¦Cg¯W¥My™KFU¹ÍmÚ«qÛ%uã\nÏ¸ÿ‡tV¢àAqØÐ‚.GWÜvV°ÿ×VäÃJS/“+Ò-!bd„ ¡´0û2m\"òOoüâbO,'†²E†?P‰0‡3Å=‹b\$¹†t“¨ÿZ\"Ôš'Ekc>ïË\$­‚ïš!Yëj)ŒÛ,ùD,34fÉ£²ç	øïz[£gøÁc8Ý)!¹.6+}¤¹’e°•h•öùSºP¬ˆ˜ÿ…ë“@óE¦Èœ[GlØâ¿TSþëxÖ\r‘:ðÌO.WJÀzÌÍ€´ùàœrD6“bš©§,Ços¥L~OÕ§™E™–„XÄxû¤•„EL[y‡*…Lê….zd¸·1Ÿ‚^“xþé¨/ )Xó½±˜¨q‰_•˜›s7ožØrŽcvSl<XÆ)“Êk#U :Ì1WñŸ+ø@";break;case"sk":$f="N0›ÏFPü%ÌÂ˜(¦Ã]ç(a„@n2œ\ræC	ÈÒl7ÅÌ&ƒ‘…Š¥‰¦Á¤ÚÃP›\rÑhÑØÞl2›¦±•ˆ¾5›ÎrxdB\$r:ˆ\rFQ\0”æB”Ãâ18¹”Ë-9´¹H€0Œ†cA¨Øn8‚Ž)èÉDÍ&sLêb\nb¯M&}0èa1gæ³Ì¤«k02pQZ@Å_bÔ·‹Õò0 _0’’É¾’hÄÓ\rÒY§83™Nb¤„êpŽ/ÆƒN®þbœa±ùaWw’M\ræ¹+o;I”³ÁCv˜Í\0­ñ¿!À‹·ôF\"<Âlb¨XjØv&êg¦0•ì<šñ§“—P9P¼fÙçÐÊ96JPÊ·©#Ð@ Ã4Œ£Zš9ª*2¨«¶ªÒ¸\nC*Nöc+¨È<nKdŸŽcY†TµƒÈà<F!ñŽc`Â‰‚´þ\"Î0Â†ˆKª`9.œÆã(Þ6Œ££2ô I˜Û\ncÊ³¨sþžŽ@P ÏDlDŸÀPÕ\$ ÂÛ­±›ð4b`9¸œf*NLÝ4³lÞœÁ€Px‹\$ƒ(Ì„C@è:˜t…ã½/ƒjêÿ…È˜Î§4ÀðÙ\rÓ€Þ7áœ	#hàœIpèã}„@è4#mc\\9©‚˜¢&\r-’R+EQƒ”‘´f-\rï«Øà<2Pê5Žˆ‚ôÕ.44'ëå©>(»  Pœä'hÓv5Æbº:7<èhJ2:7}ãy7­áy\rMhì‡†!t8£*E@P—#§6‰C,ˆ#«Z	0Hä2Õ#¤iA#¨Ø:'ŽøëX…„ÆÃ¨Ü5Œsè‚3âã;¢½¾vÁ|¾9@PÖ2A£z~ž¾VD•Œ=(JÐà¸W”–4\"`L…ÐÖ*÷ð å™¦R6\rc\0œ!ƒÂ7!ÕØ@µ¼w@ô¸Ž‰²<ÆcÎ³xÉ½Vã–Ø°mÃ-Vªˆ9ºR¥Ã`m«–ÿÀ•#mÂ)ñ]‰3ï%õ	ûAB;#dgR£P\0\"î5ÂmÎ¼ÁÜ;ÀÅ4Æ‚ÆÆcµ‚VÎLf?,³ªJ:¦\rã0Ì6RiHž2OEàÆ\nƒzBõÃÈA•c¨ÇŽc˜Í	éN…`åç#8Âº„%íI\rØÊaJR'#1èµ°Öœ„¦)Áp@ðÎ±1W¥037›˜x FŒä¼'‰Âì)…¬2† Ê›IvlåÈÍRR\r+5pŠTàƒ8 !‘ô÷º‚”èig„Q?‚ Õs@ø2)ôÎyÕb®*&©OãúZÏ	ß/u<Áœ›9ùgî@ÀÂJIYY?í‡0îD×W¥‹†Gý\raº„PÊ!E(ÅÔ„,RaÉJ‡%.¦Z©9ˆª…Q¹ÅPÃb\n¯)ÊÅ\$«EàÄÏ[÷|¬‚'˜ÃbÕ\r*~(±‚rN‘CŠNX1’ˆMI¹9Dð|4ÀÂÃ¤“ˆÁÜµØ,ÙÏü\$IÀ0†cdE‹Óˆ]®½§É+™¬”¤U\$\0ÇXi{\rˆ@Ê²úfá<l^	.\$€–#I5ò`s,S1Žtä61†/N”ÐSHVÍCÆAN}À(!©ò1*:¶Š&˜†SR¼«6¤\\7²¾Hº}ïÅ3ÍÈšŽç+-)„@Ž!p„Mä©ÄgÂ6Q?SÖKIy1y°lã\$˜6M‰Ãô+˜ñ¿à´têÍ‚qJ*âRHXy3ËPFAd9´5l\\8²2²1ù?®‘Efþ W\n‡ÂIIø<o\0ð“ÄÀ‰‘@P	áL*,EK•Iá€u˜P—ó‚N”\n¦Ê³FV:ŸÅÌ:œZ8©ãZ…çS`îf3cyêœ7—Ã‚¼K˜ WA2¤OÒx^Á\0F\n@à†åàK‹©(†%u)=¨dS\\5“ò!IKQ9ØäÍPž\0U\n …@Š­¸ &[|¸‹iÈ!Œ¶+ä®UV\$ªÈ’£F¢P˜VgÂúN¥¢<GáÞ<ˆòƒTÊˆDVŒ^ï^rt.Š\$=\r‹†\0,£ü›–sYÕ&’Rƒ«rO8‰<\0@FÊÉl.fQŸ;ìÝðz>n·áÐä—\nÈa„þ°ÞõEíU2a€“íY)ÀéX!ÔEœ?3®òMI®S®òl‚tà”YŽxb-Ÿ—0L-ª}\n†o˜BCÒžª™õ%bq*À˜\$˜.ËïCš'l!¡*ErT™ÏüÊÊË†Pî–ƒ{6[Y,À˜77gŠº,n¹xå—Vx3Ðd?!ªz Â~¶óæ9¼,1Úõ;íh¾µâ5ƒ‘àÎj^þŠXmKŸô´äzª~˜26£9ÊÉ¯A#k½‡ÐÒETŽU)R6t²}.i\$½šËW\nP „0*.i5G‹ÓâkÝ\nž ú™²_ò‰^\0¼¯/c3CZú38Ân-¾PWýZ­ªJÁeh×`ÓÜÕîàXªqâöÑîI'àº·dÝÔcxÁÍJRp(iÞäæQ\"ô[Rq…ßå³užÍÛø\$Üü ›’ûÃ)Ph)«Ã}á°Úr	Iy™Æ]´qW&Hêlh0”Ñ}à|aö£^Ð÷loîmÂ—2›œî‚Ÿ}Çy9œó§¢mŽP|ù‘Œiªöhr@	'3)‘L©­>±‚Ž†šýp£Ü¨%6%)Á«\"Ò§SþâÐ‘dÌP’\$Mâ¸íÄx‡M*[ÿq=(ì¿˜©>G¦6Ô‚É1eZ²ˆW—‰>ˆ°\$!Q†,ÒZÀ8ÈU£rKáŽXv<)\$ çÏ'	¹Ù'¬—j³ÇZ—¨FXô­ü¡9}w¦nK¢AàS²nå¡ƒù3;/S©2æø?:ÝìøþøLâ|ï|p§Ë¹í\"\r:r€‹¿D¡¿SÎ‰\rjÊd†®è°\"àƒÈ0R Lò®¹Å°^E¡±ë’ƒB6ÿKæLJì ¤Xb¬þÀ‚náO¢á¨>EGÊÏ\0ðqk˜`€Æž\0ÈºåÐ/¶Ä,\0Ââùâ,Á”Ë¯µç#/®‚…R÷`¿ì\"rOdõO²÷0PÀPTøð÷'Ì‡o‘¯•‡aO°mÏµ¬ËÐwï¥r?\r`X¡t\$°˜1/R.Íê£š~®ßŒ8ßÐ¤C°©\nÏ® p¡OŸðènHâ8âPÆÖ0«Ñ\"ab@álüÎFPàäàì% †ÑÍ µÁt8ÏŸ,±	ÁZ@ñMí±µQÒQ±vPjœâRM\ràÔ\\„P\"Ê\$'ñL¹f:V(L³Ö(ŒŒ&dL~£b\\‡ê„T{¢f^RÑtRQX¹¬8áI4é:¾%.°\\~¬ü*ë#fÕÄPXªÚ\"É4³(+)Ê\$ñ.Ññ\"Ò-&Ð¤À\\BkÏš]\rÈ‹¾Xb³¦\nÎä_p¹\r±A…³Æ»‘£¯_±:1>¥ vþÌãc¨Ö¢„(¯ÐL÷-h;ò9pÏ§\"ª¥\"Ð‘\"ƒž8S\"Â†2gHpÃ—\$²:n€ÂódÎ8fSä`À–\$Á|X¯ÌÎ	²A\nJ'Q\" c¤œ¦5pË%p(Å¥Ò4«#ó’›Ò@\"o´Ïc€zæVe¬2oÏí*0èZrRÂªeF²pr%H£\ne¤\\/ürâJ_ÉÎE àJÀÖ'¤³\"Ëp„úH‡.âre°*©Üú`¦A²ñ0P™)ìàú\$ã1\r2ÐÂ“0ò\\&ýíí)1`ð ÞÓ	 +Òè×RÕ’êN‚æÓ3“E5M:\"‘+Ò³V‹sA-)Ý6²°[­,ÓM,98\\Gr\$Ãî×¤BØ}5²ùçèõàêK¤¾'ñÌá:m}:³›72\"F\$ÁCÍ_*PêÎ\nPhÀ´\$MCæÇŸ'Ê8çJ, .>%?'ìÄ^Ì<zŽ\$æÃ]>J:é“êÖ\0æéà–\$¬1…ìC Ø(\$ª\n³ähÓüö\"A¯ž\$#Tàòs\n\rI@Ø`Öx\0Ö]„îŠX£Œ('ºZ&ÌC¤C¤1ÑÀÕk,“F@•çÈ\n ¨ÀZ\0A0\"6<îj£@\"eüœÐ½\rðÀ\r®ŽÀÔ–@­îJâ4¦\$4«I®CKéìèÉ¢’Š0œB:#è2vgj2`›HàÌE€¬aJ\$dX5ï?ÉÀU\"’6Eú\$/Õ\0È7;J×Ž-OÍG §/±Ø#Db@gè@˜±¥àäíšo%RƒÎT!.jaQíÀú‘×0dTÁBÝ/ÕDÉ°€‚‡¢}&ùŒ›LüfL±­V‹/o“Uè'V4z^\"¬ˆÀÞ	RRL¢ŒÕR0gÀƒqëN@ó¥‡\nÜû¯«=£¥3Òê\nÊ¿\"êØtu»\$ð\"Ïç»i¸RCT5¤0Ü”ä”àê¤ªrµŽöÏ¸g ‚&où^£\ndIN:9#r´ò1†KTÂßOUZ½&ïK‚0°úÀkÛa+à2fV¬Œg32ÓKHl€¬¹fÆ9xGB	\0@š	 t\n`¦";break;case"sl":$f="S:D‘–ib#L&ãHü%ÌÂ˜(6›à¦Ñ¸Âl7±WÆ“¡¤@d0\rðY”]0šŽÆXI¨Â ™›\r&³yÌé'”ÊÌ²Ñª%9¥äJ²nnÌSé‰†^ #!˜Ðj6Ž ¨!„ôn7‚£F“9¦<l‹IŽ†”Ù/*ÁL†QZ¨v¾¤Çc”øÒc—–MçQ Ã3Ž›àg#N\0Øe3™Nb	P€êp”@s†ƒNnæbËËÊfƒ”.ù«ÖÃèé†Pl5MBÖz67Q ­†»fnœ_îT9÷n3‚‰'£QŠ¡¾Œ§©Ø(ªp]/…”ôÒmg¼Ó’e¨ææó\$Ÿé)ž„Š]6†ùªkšl—°Nã¼õ®ˆc®5®CHà¾¥Ë R˜:¨ãh„Œ(¨„·#’	¨*Eˆã(Þ6Œ£ ä„Äb›¶\r­{J€¸hL_!ƒ\\ðŒPQBž6q`Ži\0!,Ð«È4¦Ì(2B£Z5#Ìœ ÇÂ¡ânÖ£0z\r è8aÐ^Žóh\\ÛFª€ä#C8^øNãÂ7cHÞ7á	#hàËÅƒpèã|ý³q`è4>Œã\$:Žh¦(‰r^é®¬¢ûŽ‰h(\rãXÂ‘\$ÃÐÎÖŒƒÒ) ƒ-“<;.28•­nÎ.‹²Ò'\rïÕj2R@P¯¡ƒpÎŠ„¯¨Ä˜Ž€M¢ZcRçkZV Ón[¥Šâ%C`à2Œr¬	q[à¹ŽNr22²Ã\$ð&hHÊ;!j4-0Œ#¨ØŸßƒ`ë*T+(Ã¨Ü5Œr„¨-ƒëVBn“®„¯ƒZŒ9'‰Óˆ\$²ºÈÛ&#}ôS±ªç\rãeY,¥Š¥þà_ØhØ6X\rB9Œh[½U7´Ø˜µˆ89µuz¾	5¦=Vuö¢Š\r²Ò*§×åE¦kN&²6¦úœ¨ò9ã¨*ŽÃ|éí°6¸:kË•ƒ%jp¨ˆ!lU´*4º˜RùÞ,Sª#0Ì*	xž2J)53*ì–È7,ôø:Œ{Pæ9ŒØ@-³ãÓs#äÚ6–¼â: !@æÀ—Úí(¾²Zäb˜¤#ÁPë·p@3#Cn„»ß‡µ£¢_'Ê)½1sºèò^*1Ø{7äLôûg\r·aOHÇ?Ï·§Ã/1¨,ÅAa|2OéK¡FQÍUêMÊ2£%°«<#ÊŸHÉé< ;„¦–œ‰%á5Âèsähú†PðƒËÓÁ~	ù¦TÎšSZmé½ó§\$è“²xƒÉí>§õ Ô*‡VË½þ(ò’”>¦u²BH@ØS—]ïLú ƒxMÔÌ#&µlBLŠÃxgeB4ødªÖA\0ad•?‚\0îYÚØ Kœ9>X}Cf‚ÄQÎ9ç@è!´ŒêLÑ³ðÂ‹\0c/K¼4‘ðæKÂ7¯àÐŸ’,TÊ•<\r\$9PÐ}¤jÅ‰ï\$\0@\n\n@)#¤™,¶ÓpÉxCOåB1,–Œ±˜§Ôõ‡C6iL‰?#ä€;Ë7jNR‰P2m¤—dMl:èN4'ñ)Š1’ç€Ü(­TÉ\">¢h¨×É\n[EC\"&LY'\r'Ô´õ2¢¤3d8°r|ñÏ)|ÉÅ…GÓÉ™4râ—¦AIÉ;^êüÉ° Â˜Tx!iË†£®µË_s5QÉ“ôGÕÂÅ™`Úœ¤'&Ïà\npÒ…ž¢@m£Uà£<xÐ@Œ7ÁRO³êyå©³'áš|¥0äLÓšU7D˜5›€êÇ\0QÔ\r&ÅuFÏ¹¨gÔ²*#ªiWí\\P¬ýr‡‚t¤5ªHÖ³dHÈò\$\$(ðž’V`J\rÙI2Ìà™„œFÃk6QixžFý`‰3ø.<ŸíÁK-æDf~dƒÑSiÆ'W‹3[k¨…©ZˆŒãù“\rîyq«F ž(vTÄ~¥@¬ÂŽá6R\0éH2‡3¨a7³2rO…NeŒÕ9ð:[ËŒÃ™3U€(-Ú¨•£wJMÀ%IT¡…Û.Ë €«Àµf1˜J(68½ ´…'AêY“€ÒCº§‹*ì¾]’ë”ð9†½«\"Ü½[“nh8Ðš|;Daû›´0nêi¹!->¹Æ„z_0¥x\"„†Äz©âI]îŒ·#ã§Š`EÍ—„g’JoÑ>\ráÁ3´1ê¨‘¥ñ¹·SÔê!P*†õpFj0Ys„µ—ÄÂ*¢p¨Ü3V%ñk‚ò°µÌ!†h+ƒ4’V#›.n¹Ã5_¬Ã,Öœ€/\\2½“%Ã\$=!ÏÍ\0QÏ®m0åXªžh{Ð™ôPÀí ±¯š.H¹Ÿ½œL8iÚ47èø¡5ˆ|ÏÆÌ=f-1¡4Ñð²úxœjÕ¨ôv­Ïœ¢ê'ªô¸aÐz¨Éxš5²\$ÁÕ¢I«‡£åAÞ×úTÉiOr€šÐðjmF×ÆÔ\"švm´I–¾Ý×Yoí8V ~æ!F_nj]Ö]wnáÝú o\">d·NöÌA‰Oî²øËb9åäT'oõXP	Q,Xd}Õ[^ Pƒ^½	ý­E¥ôZ	y½±¹õ¶ô²òYÐ†\\:9ÈÑ9;1—óÙËÊ-sJEHÚåÓÆªUY#\"‘üÉìºÄñúÅDéŽ`KÜºgwY©.4à*øs!tª¢Þ4x*Ãø«GÃ®,„[àv/÷)í·}Ì%œ‹×ø»výa„´7m¿ý½L7DCÞkA4÷Œ²E”ÿqÌ­ô4F¾W\\@yC‚!Ê Ö‡¥èN•úò¾\\’?¨üÙvó¶Ø½Žœp	r[WbÇ¶ƒŽ>ëK‘˜®pÇ'ìS3 ¤˜Àì’Òo³=Ä_EÛ+pæ¹<óm~=¯ò5÷~^&}\r3Þ>3}lŸ\nÍw#U{¸×}kÞ\0Õ·î5ÝÔO€U4„ÒøÉÓA9ö³ÎÀJ—8kØzÅ,ì}>ÍMþ\rþbþª®ÿ†ÿo°6B¨Öb-G\0OäãPþìw/®ý-d\"Ž\0ÿìå/â¥¯èïõ#àÓmŒÑ\rjÍG¶7Mú©ÂûˆìŠ”Ãd¯Îõ°_5M\$úI¢à¦ÚDBL6†\"7¬¥ÐˆÂH¤[ã££ðX£d\$ àx ž@\"ª\$°œŠŒ9ƒj,šMÆö¦\"’ãh*B¨&Ð¼ŠfRÆ\$ÂaCàF\nBÈp{0~Á°Ê&ïÀ\\ÂL@Â°Î\\ÅÐ¿Et¾¨ýSÅQ#ê€/†³oŠ\rÈ™Â´o§ÌŠ´…G|>‚‡‘)Ì(ÇñGpy,0…ÑWçñ}¥EqDGËÎ_BX]Ž8].Ô°&Î³ Ö1€Þi¤FUtÿ1H³ˆ™±RgñWã0‚üq`À¢Lt&b Ôj«^¤1¥±5¦b ç,Ïò/£ZÛP®]dd\rbf\rÆƒñ*‹ÑëæÕÑ´ùÑú>ÿOù…}‚‡ÑÙÅ3Ò- ¨ö\$û±*õï#.ÿqÆ3…×Ä8UŒL'n4>‹¶±-\$bG\$±±ø5LI\$„{ 7%qbjí`Ä¬O\$\r3'ƒºC±X(d~=’j€2PEÒT/H2M Ð)Ì‘*/£ \"^¼âx/cb-1­Æ`”Âøqàì¾„kÍ²!PÛƒÊsÐ\"Oä8åM:Ý2Ú3P.ÔõrØµc4Ô@]²Ò5ÐW/kXÂ^þþªbb8‘ŽƒvZ2ÐCŒ!'*û-rèë§¤3(ÐÍÆ&ó.ìÂæÔs7'P:·ÓA/ÓGÏý4Å\$X©REÀØoØã)Jôªê“`ê7ëj%àŒ¦è€ï¨Ô8à@\n ¨ÀZ\0A\"\"öYÂðm®äãM‘\0\r¿9Ñ*Ó“=ÍC:jçmá:0>&Ù;sUv°¾VÍX:§ôg¯	£è\r Ì \nNë\0æÇ³r–l‰)ç?&pjDøb¸oÐ-Óþ3Šq6Ã5R˜\rË¨6Ã‚B ˜\rê`Šb44%B“–:&Ôg*ÆlpîèÞîJê.³´DÖe|°3*˜´SúÇsEµF&³”\\.ƒ.3c2ê’ à\$¤j¾€ÈïKÇ8Er¿†4%õ\n…K@Ø€€Ñ¶ât'‰î’pª÷ô¬¡Iï,IÊ“LHÇB°\nÍl/¨Ä¤2@ŸH#ÎpÂ\0‚-ôädË©~,£1”L3°ÈŠ6Côb ê‹EÂjŽ©PoßFFM qðmpŒGÕ\nÅB8C€æ«,& ";break;case"sr":$f="ÐJ4‚í ¸4P-Ak	@ÁÚ6Š\r¢€h/`ãðP”\\33`¦‚†h¦¡ÐE¤¢¾†Cš©\\fÑLJâ°¦‚þe_¤‰ÙDåeh¦àRÆ‚ù ·hQæ	™”jQŸÍÐñ*µ1a1˜CV³9Ôæ%9¨P	u6ccšUãPùíº/œAèBÀPÀb2£a¸às\$_ÅàTù²úI0Œ.\"uÌZîH‘™-á0ÕƒAcYXZç5åV\$Q´4«YŒiq—ÌÂc9m:¡MçQ Âv2ˆ\rÆñÀäi;M†S9”æ :q§!„éÁ:\r<ó¡„ÅËµÉ«èx­b¾˜’xš>Dšq„M«÷|];Ù´RT‰R×Ò”=q0ø!/kVÖ è‚NÚ)\nSü)·ãHÜ3¤<Å‰ÓšÚÆ¨2EÒH•2	»è×šâš“²EâšD°ÌN·¡+1 –³¥ê§ˆ\"¬…&,ën² kBÖ€«ëÂÅ\" Š;XM ‰ò`ú&	Épµ”I‘u QÜÈ§sÖ²>èk%)+A\"ÅJ©\$†<±t¨±KVØ2Qú01ÑLêhÈHI¦JtACÉ`’)Q’ÞÿÑÒYxÿµˆÄœ‹ËÑŒÂ­,…óàÕ!ÔdW&Ë‹`Îª\n¼ÑH2\"HOÑ)Ì…Aó¾RbúÐAàÂÞŽC(Ì„C@è:˜t…ã½œ# Û	£\\7ŽC8^2ÖØðëÃ˜Ò7Û¡Ð	#hàå¶àèã|-Úìã# én¦(‰ƒK®Ñ1Œë?JÎuZÚš?Æ…`ÈÈ”.\"ï,·D\"Ä*ÔOékã4p\\oŽ6q¾&Î3Éþ6h(²—.W•0®0ŽCt\$3¤a-õ”¼è` ŒþzÎgùÞ„œ,52“©Ê²I,Ìú[VŒÈ4Á H'ixZžÑ(Â¾Dj¯@‰a#¨Ø:°Â6£,+‚å8DPR<¨Ô¶C&ë3þÎËokª+ïí_:Îó'Eå,’€‚d)nOËêCöó±ë«;V	ÜAÖé´3¼q£Ë@Ï9|—-¾œA ™š;Ä3Y?òÞK1kÉJkT	òÖ!«›6ÅàðX‰‘|VÒÇ97°«ˆž<o+nœd‰–= ±eº+(ÅufQS;‰ÃÍVVRr-,3ÚÀpÒd^eeGÞ¥çŒbé…I,_À€©Ê‚¤ðŸÍ)í½ÿ*2†bÌK†>Îýƒ2¡I{ˆð¶·Å\$~IÙZ%RÜPÀ\nláÈÜ›°@ÍoÁ˜6-BÖ'‘ºŠiAP7œ@ÚCpyÕp‡PÆÎpsÍ˜ÀÞÐs‡@9C ÂÃ\nI -0ÜN¸(`¤µ”BÆÔ\nOA!)… Œñ‘à. Œ<»2&<«MEeH„ˆGÒEK[â\"\$øÖ!²º÷a‘·(APßàÖsÃ2Ø‡k‰	‚\0‚´– r‰ar. ÈµA¾X	b€Dƒ\"ä:ÌÝx/\"Öäßq'†°ˆºö^Yƒ0.œXD¶¸˜’iF’®	˜×šP‚hag\\9Y„ÃºØ_A”<\0Ò°C\$j“A¡`¬5Š±ÖJËY«=hÅeªµÖÊÛ[³1p.%È×0s]©v.éJ¼×ª÷\rå}¯`ÂÎ8«V†åÜZÑR%%ÑC\"²(E”i1cò!¶úAJ\n•ä‡H0ÐpCc‹Œ7\0îrƒ` G8-Y—jú!šb(}œBˆ‘\$QÚ>vN…\$A…v‚\0Ç4pimaÌµ™„>S £ù‚Î ¢JäŽQÚ7—¢ÐÅ(’†D( \n (T‡”«KŠ>¢…ÐÚ±FübÅéBk’Q¦o=N1È9G02¯ à¶¡Ï;g7¶†×ƒ½u‹¤Ê0 ÒjmLcÿwe®6AÆ¾UQ©5y²Vª:AsAM‡½“?×š4J¡cLUf8Ú‘J+ Èµ•ˆÄÐÉZFA\$‡˜LJú8m¡~†åôvkÚÁ-¶a‚\0Ìƒxm‘ÒBLS²·)ôF_´æ½‡žlbIÈ±2U žÂ¥S‚¤ÎÔPoÂ\nyÙ–+ÅR‰šŸµrõK”«`]“ãO‰r45Hìd¨=çuÈ­ß2gÖ–¨U®^•›ÀÇ!Úë\rëFÒ ÒÁÄ¸ÕÍ´Ô @‚¥]‡è4®ªñÛEÇ¹\$‰jœ¬z\\-hNilL“²·Ðà¡s·ä•'¦à‚xNT(@‚( Ü‰Zµ:j‘Ù<»uX÷¡`\n@VA\"„À‹’2VLqDIÜ'!b¢H‹ Ya–=’\$,¯é@&Ì4¢*ŒÞ÷\nû†PêÝ7:3(â!‰uÅå†¿Ê¾ûH‹»dÑ‰9\n\nÜ«Wd(•Ç¼rdt^wf ²g#]Ë2ÉŠÎ?Á#jûß´êœ§’›ßXyj|¨ftÁšs›ƒìDÞçêö xÐ}•õ^t¯ÞÞ¨{ÏéZb}¨›âº#Á¼Q74{T*˜ùP’VªÆQ9ö¸Å\"°\\½4¤ÀM½º·Wlî©Iš¸9p¯¹.…Ä¦î‚ÐIöR&N“@«Ù•vêY¥M…0Ò›uk]Qa·0ÊrèÕu€ˆ]0!´Qìµb©ÒÆ=ã³å0²Õ¨P·ˆ/£’Cº¯ Ñ¹§¼@ÛÈÓŽ²ˆqñ2W®e9Ó¨Û¨X©5aLMÄËÕAˆ£C9‚!Œjº/´Û€&J¾VúcÝ(µDš%X!Ú~ÆW6¹‚¡Ry³÷Â}\$¸’\n²e4/3+ò¡+s*’œt3°'|FŒÐç•vG\n!„€ApùQÎ„ë¾[Ã§]Ã‘×š.püÐæ_¬Ï/hcu}ðAç\r“Öh¾†§ú7ÆËœA©óVD‡“¸öR#ñMÖ‰Ò†•X–Ðï¬—ºLýP\\`«Þž¸ºÇÓìïÏµ´^Ý}>9U¬½Ùn?vŠÓüTMÄºø‘ñ÷'ÏÅ_(½ùž“x›uª=çÓ1µØäû'ÎSž§ƒÞÒTðjP½Åg½¿h‹zÿŒûÂ\$ÏÀ÷ÏLÿD‚éï0ÿ¯Šû¯e\0/èü/ªÿ\"ê½©^'PûbSÐù'Üú‚‚ãp8ãÀ`%¦mâF\$©hvÊÈ-§˜–m\0Îe@)ÌAÏŽøm%ú+ÂÀ-äˆ<-bÒíÈkÄÝÐ|¬%êzš&Ab¢CRðˆaÄVvCL>-—çXØ!.%úU¨ÌK¸Ì§p,qä0b-€=ç¡pÆò¢Èa§2J…vI.\0Le\"C„,jk2àFÇFP(êÂÞÖÄLÆCpÛÐþÞiaÄ?®NÆ.0“kÙqáFâ–ÎþqÚV®lá*.ç£MñCQ\nBs¢¬°lìÇÈ-6TX¬dþc:Rp¤G‡:Øl<ÌæI«ô.Ê@ˆ¹\0àÁb9­Eˆ&îÑŸ¢r5kÅFQŠJqŽrþà'òÙ1J?ªK\$å?vqHi…rÉj¨=§H>LÙ­º3ìUN´¾q8ïç“ñô‚M”¼qþ&®øÔ1‚O‘…íXÔçðÖ	UqX&ç\r\"¡ ²%²)cÏ©î@y@Ö²òKn¤d¬ b×%r*&±Ê5‘#M1†\\Ñ¥G!òXb¢,LÃäüosF@úP	È o´cR‚ÏòˆçÍbÙ2Ž&Õï'2–W/‡)Ì*Ò¢zÈç%Ñ)<<. sÎ¤Æ¢,òNã‘\nG2ÐQ2Æn§-²ß\$B3.q].ÒØ=oÏ\"ò_/p@r,\n>í*Œ\nw\r<²G\"g­fq*ä†’g~Lâ‰gZéÇ1Œ~ÖVç±ƒât®ƒRú*óJ±3tÑR Â¯4&¼AG.ª¢Ú¡nî!¦Ö‚1-sú>,hê èä31S\\áihãpôCŽšëlžÓÆW'&BÑD{Rk“	ÓªzÒß°Ö­1¥;£i0\$ÿ0sÄÍ®öäÓp2s­°h%é;òS=-d.æës±\$1Ì´DŽîOz<óÍ%Ñ\\'Ç\nÔ\0îŽôÔdÒ«Óñ@'©¤Æw‡ôDmŒ?ä†ë¢Isj#H‚j >°B†úí®Þt²gƒ<\rq#NÝ)ôQ/3ûô_+òÉ0SS@Ò¤>án§XÐg2Ø.{,F>³mª†&2|î×%ðÕG£ÚnÓ6uô”Ø’1:øÚ‡¬?¦ŽkÎw¦O(ƒÓèÖêÐ°tÄøhíJ“ÑLÂŸFRl÷Î”ÀÎD€sÕA¾5Ôèj{Lrã0ŒQW<ôN'¯OðŠ5‹þsÇÜL´À`ë®¯O‘==5\"N¿MÓµRŽ­Rõ@’3GTˆë•,@HØcØ§ÙTN½T¡FJNâÙ>3òr DŽÿOuRSÂ-umL•qSn-daVìÉ@beMbH¯aJ§’O´k(FV3X)ËVê¤Ð*vô™K	Xÿ“\$FÊÒôu·3m­Z3êœäõÅJõÉ	O†=µÐÐÖÏªÎµt.bÏ2øætÓ•â=pu\"±!'îær­ï_ð½\rõÍ,¶\núîôÖ'rª÷²Î@†€ä\r€VÓµŠìo“,Kö.ôC5Sø´Hð@ŒÃ€Ú«Š¤h¦£ ª\n€Œ p¸’‹pBoðù®}[Ì§\0q*Ož{g¤àvôÒ¤õi.Í¢èÝb&Ù+ÓÎOä\\U§‚f6	¥ò\r Ì.ª%¶FC’jsÅ2Í&ìd¯gM’eËñf`Jó.§JBy:Çlõ0ía1v²\"`\r^ÕVüë\0005GŸHå<Oñkƒ8!Žk9GwamDïƒ:Õ2¢·'‚tú˜ƒˆú)#Lþ÷;kw?hÄ—ÈÃ7ñAr—S22L‡“t×_sÏ[tœ12„}Ru'×mQ£:Ä8±²ÓCò3whÆQuvV„UñrnxtQèÏ÷\nÙ‡BÏÔbèÍ#þÎC>‚\"wí²Äõ\0\nÊ2 ê\rµ¬Á7}\r#Ðjãä»Ì}í,fåW0M.Ìä§*\r>aÖ°)N@¢Y(§2-M*’=}8Uø£R4²àŒÚþu²@%^Ò†F|6JÞP5d7D\$‚æ";break;case"ta":$f="àW* øiÀ¯FÁ\\Hd_†«•Ðô+ÁBQpÌÌ 9‚¢Ðt\\U„«¤êô@‚W¡à(<É\\±”@1	| @(:œ\r†ó	S.WA•èhtå]†R&Êùœñ\\µÌéÓI`ºD®JÉ\$Ôé:º®TÏ X’³`«*ªÉúrj1k€,êÕ…z@%9«Ò5|–Udƒß jä¦¸ˆ¯CˆÈf4†ãÍ~ùL›âg²Éù”Úp:E5ûe&­Ö@.•î¬£ƒËqu­¢»ƒW[•è¬\"¿+@ñm´î\0µ«,-ô­Ò»[Ü×‹&ó¨€Ða;Dãx€àr4&Ã)œÊs<´!„éâ:\r?¡„Äö8\nRl‰¬Êüž¬Î[zR.ì<›ªË\nú¤8N\"ÀÑ0íêä†AN¬*ÚÃ…q`½Ã	&°BÎá%0dB•‘ªBÊ³­(BÖ¶nK‚æ*Îªä9QÜÄB›À4Ã:¾ä”ÂNr\$ƒÂÅ¢¯‘)2¬ª0©\n¶Ëq\$&‚ í¹±*A\$€:S®·ºPz±Æ©k\0Ò¸Ü9#xÜ£ ÊU-¬P¼	Ju8“\r,suY©ËÔBæÀ.Š­'â˜èôI-\\µªŠÒW\"¥u,ˆÍ±‹Ÿ·(²­J!\nù€7\rê/Ö‘<›-Ë2W*ÉÃ{cQkRÄTÚPãÖ+C£+ c@Ù¥+ä-VÉìòæ·ºæ³Ô­äbã(Þ6Œ´ûTãÛíêéÜ­õŸ2AåÂœOÙÑ°P)#›î6ÔJº¬Z*ÄÊœ°ØWøÊ9<#–\r¢7­OTÕsb|\n£ž‚×hùqC\nRR¥BÍ„Áä5|BÆåhŽ3)Ö¶¬1+%’\\à«I‘m5À•NB¤I‘ÖpD!ÔSG‡ƒ¼9£0z\r è8aÐ^Žúè\\¢²F\rãÎŒ£vÑ<í3äü„L\0|\$´ïeØ7à^0‡Ëûáv?#xÈø¾xð@)Š\"`Òû¸r#–àÙ{s\nY–äß7)S5î¸D6Ä@ˆ¦D2”¥n®T×=\"ßDVY\"û¥«î\rc%)Ý.ærpESÚ'R\"ðWsÞm×=¸êè=íßC1ÕƒrA´ÛR;+Šãä7I:BðtEl?ehø1Ï[™sv³e\\5c¦ÜÛÙgé §ªä+ä”²UA\0+õ„F¢C¨l€€;ØC+±r¥8¾¢’™JjµÁÔ70èŸSÜAè^ADÒ\ngí@3Ÿh@ÁN6G*Ø€0¥tE\njtD®mÇ&ÈùáÔ:Äé„°¸vëÜã ‡H†?UYŠRzNåe¤ÒóAKi.J\r@Ø|Oñì\$Œ0†äŠâJC}*Íû£´í„dY@q\nÄ–\\DYÁVhõÜGtò«Ì5®…Hº¨LÒÆxÑQäš–_M‹4tOî#È•¢ñÊDS‰	Í¡Di Ì_\\w\\ÒU Ù´d¢n‘)Ñ9zzBR¶6#`^R4o.&\"\$'Ï!#²ªsdÚ8\$ô‚±»\rnÁ²‡F\nÿ¤tññ/Šäp¾Þx°dêÉ¤u'&2“ñé–M™G9”X\nHÌ	R²bDŠ‚DÅØ+. ÁOYð(9\0£¶w^Ñâ\rá˜3ÆÄpùy-érb\$@¨Ï(mŒ¡äAÀæCc=áÌ3@@PÃ:H`°ø‡*(ajH©ó6ÜO¸(`¤¯0¦‚1H6fÖLj« ¼Z^Æôš@„ Ar2[éÊ>\$8üÍp®u/¾C¬£Z^¡diLÐFÐ‰òï\r\n‡gñ*£&r‘BfôYårD²©ÊrÈ+ÁPï†àÖ|3e¢©ñ\$‚\0‚)s¤?'ÀÈÃÁMiíE©˜\0Dƒ\"~…É%½7Ä>E¹V§ñ¦%ÔURüN]j¨Ì0_ÖrßÝ¹}©&Ž¨Õ7êE \r-‘*ÒÊðM,\nÄvÃ»epa”<\0ÒÔ%I±A¡¨5&¨ÕšÃZky°6 äÙ3hmW=6æÔÜC›sn¦™´·–ößS»€\r	Â\n\$Ï‹<Ì>‰ëËeê™D6l€ë	-²i7e=X+©v†‹š\r/„Ú×>ª¹\\ÃAâ0z\0îzâøb<AÁ‡×ä»aÇÜ9\n1Fƒ£Ô‚•asò|p‰ +°;‘yCLuz §(OwnMe ”(‡PÌs“A@\$‘«ÏÀI¿–{o0Ué?0ëÔC²‚~¾ØR¾Ÿ#ÌzQì=Îf è|Ùã\rð.0înL°D2úª˜Tr“úÊ\"º(˜J°y7òF¬ù¨YéëkÄ”²1í.:P…h	Ä£åâ:•Å¾þ\nåoTŠq¸Pòyäz£1]£dSbÔÔ„(˜]ts0e4!4ï£‘\r`Y\r-¿‰0ïÞ|¡DN­…Õµ‚I'p@ÒàÏ\$cÁ¹ÁŸœâÔŒ`@€3%×_¬ÖÆ\r§”7\r·…¾=Çi­<kvLÁ‘¹ÿK…\0žÂ¦·œ«ŠX‹W:6U ¨n™H©Âä2ºœwú*¦—í~äuLh¢^ÐQapf\r!œ:‡(\\Ÿ¶­Ç¸Pðäi°¶q(;[R2ê*PŠ&!‹‘¸xÑÈ£êiÁ*dèÊàÃI§™´®î]ÎÇ˜ƒc3Õ®¸å5Æ™	fÊ•æ”¬Âí~ÖxO	À€*…\0ˆB E]ˆ@Š/igUp¬ùPd\\:Ñe3-6k5¢º/CLŸ…µŒ×k|õ	zªÞçTT¥\\êsÓT/*9¦Œ¬G\"ÉH§Ç”rÚG˜÷òa—D;DB=û^ëÔ¤„ª‹8õ,Ú`¹o=Qüy‘×ˆpV|¯!þ~V‹?Z(Co«à‘r GVg¡zÒÊI•GÒx,õü´LŸ'Ûo})Ÿ·ô\nþz­œ§®ç×÷žb<üê›¯fìõ›ñ/H¼Ìo%¤%ïUŠUM*ˆN^-êŠÞÇØ_À¬{Lr?ãÞ`¢¬DBgS¢Î1å:? èªf#càÖM2¨¢MŠ?-Ì Î\r\0@ÉŒœÈöÂ£\0^H³H–ò%[ZŠ\$«\$4 b~\nF¢j\0æ\r@Jƒx&Î¾TÇ6šåäóŠH ÒH\"Ì#N¦\"\n`Ê=ˆ<ÏrœD CF’mB4i,©ðŠcOˆ€Dzûã|#\0P	 Üªp`¦l\"¢JhKtÄŒr ÐœpcÔ îžgfê¯\$wëPûÇˆ£Z÷¬ö~n²Ë7\r‹Ž’1øbÎ:‰¸'ñ ¸Ž\\‰m„y‚`Bªãnþ1ŒiÇ\0)JOîó)‚Î®ïB&ÏFÙ­rvO*ÿèŽ¨òÔoÔ ñtÁ®­‰H&ïð%†z´!`*EpãrœjÐò*ÚŠË^œa,jŒrÉÖeüÆÊ¢Iœ+äÚBÇÒÕÈ'ÆuÂ#°dçV–¥|á	‚áFTzÆ+\nŒfdÚþ-–“oè“ÃŒí\0¨ †	\0@Ü&\r#Þ\nÎM´(,Ú>ìòÐ\$hýYHêáM†˜Czü\$ˆ|Én#gÂãÉãr|²NîÑŒú.ÿ-ø”Lô.úù9'œG¬t8xMj¤‡Í&Žî:…‡ÊâÀò|û\r*â \\21Ï–”ýê/û'D÷â\"Òr˜sðo(RZZdïqT-cOý,´¿o*Ž÷+/;'. \rO©Ð2~ÒÊ±€ž\n€Ë¬’+²L´Äé#N÷*ÐÑ.„0üR•'1òŸ(l©#2¦œñ€¨'Ù+D…+=3ó'-è³.)Ï1Ñz£ŒqFÂmÌâB0AmZò‚¸¡±V'â‚(b‹si4d,ê€ôð†z«“xçÜú²º«R¿4zð%L\"àü²‰#n÷„1/Cšòc@F	põ“¶ïe8DÓ­?=Nô:¢§î¶ AæŽ)	 ¬ÿfˆ-êÀd3ê,ëi,ç‘/«`³ŠŒµÄfáïK®ì–*ŒY	æGCfãÀ†=‡´`ª®Z/Ä’ôAD,J\$°þSÜ^kJfÑ±:…/²Dr–ã4Ny°o=Í!Ó¢úñÁ)­j8	½Eg®™FÈÄ 1PÐÔsF2Û(\"S8Ö‘›H¨út'³%J)Ið’d*Õ´#)4­4”°¨ã	yJ1¢©ô~Ê‰:ÀÔÃ5TÏK1	Ln›gFñsQHÈhÁ<.­Hse&R¤à–RØ€P€ÀÌåÍ=H‘3o6Ìü#Q¸,îï2\rk@2RÊU•8Ùl}?…#O/Øš-éß&ë/1(¥£RÖÛ‹‰rKå2\$4´œwñ+S±e&‰gUh\0@\n€òÃŸ.ë,’T4€QE €†&Ÿ/‡•Mü‚Š¯©GGrÝW±íWõ·ÆfâNø¶¯ËVçwL“Jô·U+Tv5³&ÚqH¨Öœ´ÙR½\\T™NUË1SD”µ÷]ÓBßE”z±¤Éá#«J•þ˜6IrýL–!µVf–(“4IM”«^4Å^v”ö=ö@óHÿÍac1³N68wæÐ…fj¨ª*U0ÔERÖ,±Ò‰«a®!’Ä¬õœë½]õsa4ç³Á)Ò¡ 1Ð_qÔÈ”Ý\0ª€5¶ƒ\\‡@ÖŒR«4\"—;rËV1éaV`Ø–¦tSÀCŽfmø«Ï)äÝ2ZVK\\65Eµ=7I¥mÎaa³§cuÉ¶õpÖ×MVG_Ö…fUx1#Çì†äÜ}ÓA%×\"ï0&ªÎi±eVq#Q‚êª«=Ù–»puIŽqäI& Q€ÌaæÒ£GìòÈÇ!‡ô1FA³½5d÷ËLò‘‰uª»(á_AdA·=Y±t%†X·Y0Q ^Ö.J3úî‡átÒÌ­äi#•ï%k&”M&…9PîÐ5Ž  ¬ŒÈvz¬&…yG:šÁ–µzñp‡ÿ1žµf”êŠ—4qò+òÒîæZî­|Ô=D“Ô‘SÓ5Õ‚jÃrÔÇ\\‡e„5»b×+:Vq—1„a[µû wclwpD…'—4\$;dT^Ð4Û¥iƒ\nƒF£Âo…–Å„ÖQf¥—ËgOÃz—+J˜¼±;WÕŠVi\\˜ŒrdÅñ‹x»‰Ø€zx…dµuNÇ†/i\0˜¯‹4ü­U¡iq»¸íh±‰Q®ãØøÈØj´x#DÜú	ÄJIVµæƒÆ\nÈbøüÃ†þX\$CÞŠ¶ß-KAv¸ÿˆ–9¤½ˆsçzq“7f6vxúV·…´up6ž¶²òÑ°Ô¸If8]cV	ù}—%•‘9Qc{•´Zƒh:ƒîQe÷4õÙ\\ù\"áÏÓiøBH™”Â™šÙˆ÷IÇ*Âšx3 Ýd—Â÷uz£i—7VÕ3œ‘Ö+–8£˜÷/^¹ßiÙâ‘XÚ~mƒ¸q…øutáe¹åÖ£dØå`x© ™õ Ù¨Øä§Œ)Ÿ.ñŸyÇŸ²‘W9Œ\nãÃSYWÇ[øoŒXçŸÙX`Q¤ Ë‘'ŸöžØOŽšSCÓÞ'úY‹ö¡p¨œ0‘œ™ý£˜ˆžq‡€w!:Goú–•è©‰M1y¨ö¡kŽ6©§Z ªš¥X9¹¥ú…¦9g™jHZ‹—»|é)W©ñw«˜¡ú%›¹Îœd™ˆ±Ž­•Œøòð\\b±×Ó¯Y©7Ãª×‰eZ8²­äjª;c™Ñ¤Ù\$U;¯ù£±ù}°‘ïzé–T•¬š°@·l\"™W–ñy•îÿCi¦™' ÿZüÀl+tk‰.°sEk2Ñ[•ñ¨7Fïx#õ5+º¯2’Y€/ñgÛƒ£{†¶3ý1òí^Vinä—}p'ô.OÚ[“yYC³”|Úz¨oæAã?ªáyO]0ådxLX[)¡5Pª–äwÉ¹{ßˆ:—’YË;çª¦€^;ïyk÷;ÀSàØ`Æ ÀÆ\r`@å\rÈ ½ Úp@ÒÊ(qb¼ÃÖ<@ÛÃJVæÀª\n€Œ p{Ã’+Û}ƒ\nž˜“å‘ûêØ¶™i›H•¬)Åë²Ø`µ[õ}•a0ÚÀm`þ»cU)”éLÝÇÇÛ…ò¤ûx-Øº\$†3´ríuÇ£zT·¥B/K›¢ÿíÃ5EÍ`Êõe€Øääö†sDLj­=ð;htþ©ùwm)•„£QÈ-€VW:o¿{P«I©N\"æ[5°õö+èÔZ8´@˜ç+Ül£Ä>£ûÓr{»ÀhÈŽï,üA¹#“¨+ÊúË.ž5cžºÇžâý¥`äƒˆÉ\"Ðëjx6ô§}omº»ûÖ”Ë³¤çNÆÀªa‚¹‚ÕˆÔï›\\”ÍË|©ø¡¤ºeŠtœ\nˆÃ!ã¾<.v­Ø\rãPé0šÏ‹´’iÙ	k{Ñ¹³MÈÍƒéI\\Û€ðÙ}”í}ÍÐ(dyOO¸ñ?˜¸I&Ä†×aÒYñ7XÖýi`ƒìèf ‚:-,Ó6P`ê ÛEÍ%xÙ‹|@P	ýÎl0YhW-EKû…R^½ïò³È£yý\"gvMÂËÞNÿÐz\0©Öè:>Û¿Æ÷.ö37ÚÒDH{×HãŠõO»Ë´;®Ý€»Úö˜sz¢ú §O~Ú½[ÚùÝÆÊÂErí|zðµ\$Ñ½ž	\0@š	 t\n`¦";break;case"th":$f="à\\! ˆMÀ¹@À0tD\0†Â \nX:&\0§€*à\n8Þ\0­	EÃ30‚/\0ZB (^\0µAàK…2\0ª•À&«‰bâ8¸KGàn‚ŒÄà	I”?J\\£)«Šbå.˜®)ˆ\\ò—S§®\"•¼s\0CÙWJ¤¶_6\\+eV¸6r¸JÃ©5kÒá´]ë³8õÄ@%9«9ªæ4·®fv2° #!˜Ðj6Ž5˜Æ:ïi\\ (µzÊ³y¾W eÂj‡\0MLrS«‚{q\0¼×§Ú|\\Iq	¾në[­Rã|¸”é¦›©ž7;ZÁá4	=j„¸´Þ.óùê°Y7Dƒ	ØÊ 7Ä‘¤ìi6LæS˜€èù£€È0Žxè4\r/èè0ŒOËÚ¶í‘p—²\0@«-±p¢BP¤,ã»JQpXD1’™«jCb¹2ÂÎ±;èó¤…—\$3€¸\$\rü6¹ÃÐ¼J±¶+šçº.º6»”Qó„Ÿ¨1ÚÚå`P¦ö#pÎ¬¢ª²P.åJVÝ!ëó\0ð0JË¶Ÿ­ˆ2¼\\Ì+ûbœ:HÃdÔ­IúSÅ’K¤ò¥QZ\0QŠL\\N|å9©Ã†è7…Ã[%BŠ#bð£Qi(ÃŽp{°°*\n”\$ìÏÅÄ“&Î4€‹Áî99Eã·/'ÊÊEÄ“¡q.Bh8³0b76\nzLµðŒ…M\$#;rÍjæÎRË\\ƒ¹²Ê¶H0KTXC¹ˆfŸÆL}¶€ET}EnÑjÚz™ÍS¹*¬¼“ü”ž”w‚BÕ¨€jmVHêŠ²¿—¿]ÔŽLÛ1ØHUì\\R°å]Ïxrl8JìTÚE‰Ü^RÝÚïE,î’|CMÊ ¯ÑÈgyà.nDád‹†OCN³*©œ¢/Xä2ŒÁèD4ƒ à9‡Ax^;êpÂ2\r²¨Ê9Ãxä3…ã(Ý®(Ü9#~¾1ð’6ŽÈÛ¯à^0‡ÔÀA·ÀãxÈÿ@›Þ)Š\"`Ó¸¶ª:ï»yž;^,MÓ·E)“!r­Ûì\r	€¶-ÑYË5QÙ\\a2”îSóq=yNnß9Ë87£OÌ}DŽáTnße_b\rã\nãä7J£8æïjœ4—`Vó¿,Ã‰ÜhF`kœîJ+4ªvžÏNm*à—Dˆ¸'rÎ^¶ÉÍ·'–TuloõÂIÜ8à–€P‰¢#¨Ø:°Â¨e]	dÂ¢Ä0S‰á9\ny‚)#±ºrCDý9\n²@‰]R«M\\—DLvÈÑÒ[‹íE•DåŸ3,CŒ©“ÓÏ“ëOådÇ¾s¶‡ÃÎt¥Üª2zœŠÚã.(EW‘²²äYz¶+©Ü®»¨ŒŸÐl?È0ü‚\0æÃn‚ì¸µ@âÐ\0Lu*0ª!•–[ªŒnt¸:JëÝ#Xk‘1¸µHãa\$pupÖº\$²!â°c\r”6†²¢ˆá±<²AÈT¥ ¤#AŽ‘8­“¼¨Xñä¢4	‰8óP”IfIŽ(W,‹ 4›8r)Ø7fïÑ+1È¹¸¥Çß°B‘ò6CBHâ\0Sû@(ô§„{ÃxfÁ±« ùP’—2g^ìà@Þ|¤(n €:¶0êÃüa™ý\0ØÃ:U`°ÿ)¶C8aJ ‚y‚VöÕCpu@  9‚——8rÒÅÜ\0†ÂF\$Ç(ëš‹ÎÙ°†GAÊgI-‘k/²Äé\"ÈLvÜª;Rs9Ä2³…4‘8„„þ*8'W’¦v¥`*ÀÜÏèfkSq²%`@Z£VS°1¶fÈ¸ h\r	¢4cðdlÈâ·&èVœâl¡¹AÐG\"‹áv†ÄS¨:PšIÊ¶fdõš²i¦¾_Ra£‹ˆ·¢íÔ’Á+40‡4\n}aÝ­7°Ê€ihaT¦‚Ehí%¥´ÖžÔZœøjíe­µÖ¿aÛdlÀ½´6ÔÛspªÍÔÄ7pÊÞ[Ùÿná„5ž÷|Ú¼Ùn\n¦˜9#š¬Þ¹}XYaÆ\n´Ù©¤ƒ„1‡J¶¹øŠAˆ÷‡¯Nƒ“ooa„3Wø­7çsœs–sÎš¹tP9þ¹AÌ0¶ð@ì[p\r/ýLG|cÎz¢ÊH‰8tÌcä®·í>¨—nÉÜA‹á@\$\0@\n@)PhR=¨¢zöÝ¹Aw—\rÒG3”UJ¸\nm˜7[šñ[áó>§ÜüŸ¶öÐt?¨\$ø÷øÿç8w¶0¬Ñ‰2Œ(ap¡é*‰óÍ\r\"â¿Ž^;ž[Ž\nt……;¥’ª§‘a]-…Øá\nä¯NiÛ‰•™ÛÖ„ÖäúF’”}L€’ICÉé4·³âÿðn¶( þ´0ã\0kð ÁÈ7†ÚPq-€@íz÷Îvýz± pž•ãç–p¡p¢Æ¢QÊÄ[	ŠÙ]'¥W/‹‚ìi•¶b!J™æl,£]‘@¡y¡F!BQQ.zŒ©âÐç›´:|ê*/:Hœ¢ÕSyÉìóç(±Wçjw, ÒãÐGà÷Ÿv‚‚¦‹-ì4¶Ìc=æƒÐ±Y«žæ±ÅÅ- êx™²R\"âK„#®ÚÄàÁJL…\n	á8P T¼‚@Š/\nz¬Wy(ôkÓâlJýc…äùÍ8(²D½Htœ¹|‡ë',wGcT\$|zÙÛÖ÷†P‹=(¥e=9šc\$¿>tˆjB}<¨ãù¬4é`ÜK9-¥£¹c:¹	ÆQ{‘Ø¿O·¸ý,ä:ì–_RÍ¦p\rÃÉC·-—P—	ÖR9nÐÆºÞ—aüÛc“ü¥»(;±4ñòÅWâ1jI±Í’û™K€™[\\1EÌWp'iup`Ìb%RrbL²jÒâüÁG).Rz3¬™¥qâQiÈÇð-ê¸ùhJA¤=@,FÛ'Ô«'ææã¾˜–¢¼¼¡}Léuî¬¨r=|¯÷Îf{Vö}Ã(wYQ‘Û{kì¡R¿.dÂ<º¨ÚŸ]r\"<.E0B»÷2•,f<ðö©5÷tõ{‘¬È¹ÿÁ¾Â¶æy¨™ï\"ÈâÍìD¥Êû:NÄ|Õ#¾ä§ÄÍ\"t­®?i†DDî<(0SÏ;¥êŽ‰0Òí~ÓMò;éRvä^(ÃŒe&Eí2+…Ð{êÄæå É@ýÈðÉ‰èCÂaJ\"Ì6ÙF2N\n€‚`þjàÒ?‹–hljÏÆ\0ä@¬xØH»ì‚ø®ª}ê&[‰ì\0^3¶D¤šú¥ffäZZ%tDBfØcn„JÆH%;y#¸Žã¶‰H‰bæî£ŠøŒÔó¬’Ø>ƒ¨ö1åñjÞ'pÌñ¢&+¾âÐÔ¤OØ¡Ð®}	DzÐò•Êd¬„ÊS¤Da@pFªçŽ;ä9‚¶ýB¾9C(ÞoPIqP5gá„ž2e;PètKƒÉae&0Dš(H_¥ÿ1`\nàÊFüMÜÛhªô(:|æBQ‰Å:{'XÊ`Qd)…²VÂvã‚äVÉžVÂ~G#ŒrVÃhãÉ§Åü9±ÒVNò;§æ%Ð&hØD£‘DP\nò e‡%îRøÄDì\" H16¯u‚Ø<%âŽë\r¥P+#°µ¯¯#ÆPrÿP23\"~g/RO’O#r\0W²úÒ®ÅIU§g&R.5\rJ¡²Zt¤`‘ÈFñd8MôüËþ×I(<.ßJ&ëˆ¶b±Ñ\$¢vÈ°T0â³	VSÄ(NèO¢¶r!E+±1,ÿ,pTûN(£©&ˆR¼ä¨Ñ,E—*#Zþâûèúàüd#)÷'áO(1,}îû\$ÄSíàEŽ0E§¦ÁîN‡&\"àRãdpéÆ3)Ã¾ë‘t¢#R/HöÓ(aq)®ƒ3°90„¿Í=)Žµn¢£kï4S4’øt2üüN³3sV’“=5Év’2EnÁ7\n°’	8ñwŽÚrRk%\0§9‰%s@VÈõ7o\0tcQ:r]*r÷\$w0{P:BRGŠêw+…‹ŠQ¡k*;pÃ3ä•È”¿îøIdÿªbÞ…xÕ\rñ\r“°IS“8ˆtÿÔa-ïQ#@äL·ï¼:HÜ8Òÿ9MáAˆu\0#\0gI!“¡644D±Y@Í2æ„ÖìJS;S¢þGY1.-1ÅC‡§>RÝî3jVÇ\"ÞHv®ÔlÕŽÊE’¬ˆE6}Êûgi°dgs¢<\$YrârÂgF„œzMæþ…FE?óÛK°\0T´\nýàö+}”¾Ög%äN\\Ö¯øyä#K‰@tÃ»=oñ0oí/´3AT†tóðëãPTõHtE6mD²IN…Q'lVÐXƒÒ2aÓ‘PóÁ4hIR¢ÙRõ3P£‘B‡G4¯ï7³½QÇ½(•Bõ5GBGs	_S³rûµO;”17Õ)UÑº'õ3&ô§Sõ}Â\nW*”q-¬˜:#hò[!)Uäj]Æ Em6Â1åYÑ/(¥<%@¤=+œÄ³4G!Ì%ÊŸF­]0TÈÙBÕSP5l+ß\\ãßTŽÙD”EÕs^Õ\0ü@@Š\0ÜÄæÍ7V	7’þÅ@Þœ È¦‡XSc`é»aHµ_ðmb%bˆtFnVÅpB”dƒÍE#0•¿1ãr«0‹a5ûVSC8–`€6e^JíQ•k!ò7fæ¼œ6uT´ûUUvl¶chUý`UëOöW•lJV•g™f”GQ³	Åh„–K_Õ×DµUdc›kö±g’QÃ· \"¦+q8Yâd¶-Q¶Ç6ÊpW±€X\$Ê\nƒêð!hvk_)«o÷iµèþ§Yj6‘p–ýê“lÑ%—	WŸqsºàAq÷\0jöæ4÷7p×<„‘ZuzõU_(µƒ41a0uok‰U%OSÖqHùqŽ“u°s=óÌÃ×+k2so&ûW{vNÆ	\nú\rO=.‹Rì³¬¸'¥Þu–ˆtdî€í?>„•„4Éu/DQ¾DJÃPWÂŒ6fyFE#Š¼+7ÊZTß{1\"óÝ(´E?C›G“úwwª€ä\r€Vi˜`ÖÖb\09ò†8ÖØ9G(.d+\0ŒÛ†î­º‰è«€ª\n€Œ p‚oG‹‡’8Óïk»³‚%–‚Ôå-bÃGâŽÍ(”Ô5fÄ\0	¸HÀòÞPQ¥|ãŸFÂ\0“Ç›ÒaNWx6„³JÊî*3ë\0ò\\˜9Ç.ê}7-vÓMe	,TBôdhs.˜b¬˜Ê\0	€ÞÚ`ÚkCÞ@d¸ÞÎ„¬aè+èðVÑùLr¿‡?;ö|t¬€V2@€ÊŸÎY‡6Àç¤‘lWË|ì’v97ï	J6Å’ÒgD56Bˆ\nˆ©	Ø=Íª­\ràà¹ÆªùËy(·(DEñRR£YïG…ÄÂ+¹9'n'G’”ˆSUJ8…2ŽT;´e˜S&8Hz.èG4™Gb_-ß–Ñ.J\\ÈG….@¬¹€ê ÛNdŠQ¶Þ-DîB‰<Œ…p'¡<úc¢9ªB'¥ð„.LõMüe¬˜EˆYÊé\$Ã¶_¬\0õHq.¦ç“¢ON€Td96S“I(ãŽ‹’q~“’q}6fQN®ÇÎR¢ºr5EYxQ»~Yª:C·£¢æ{\0	\0t	 š@¦\n`";break;case"tr":$f="E6šMÂ	Îi=ÁBQpÌÌ 9‚ˆ†ó™äÂ 3°ÖÆã!”äi6`'“yÈ\\\nb,P!Ú= 2ÀÌ‘H°€Äo<N‡XƒbnŸ§Â)Ì…'‰ÅbæÓ)ØÇ:GX‰ùœ@\nFC1 Ôl7ASv*|%4š F`(¨a1\râ	!®Ã^¦2Q×|%˜O3ã¥ÐßvMóÃA†\\ 7\\Îó´ÀÎe9ˆ—3©ÀÈa:sFƒNdépÉð'˜éÐ«ÖËtFKÅèÝ!¦vtÓ	´@e×l8(¼Ür0šàûûù”SÇ@ŒüùKªK:›\r†t/2u=w“îÝ\nŸ˜1óq¤@kìöèúDÒ/áÐÀé”éÕ\"Ëµï‹¸Ÿjè¼I\n>ç°O Â9-ÐxÒ48Úî%ƒ”6\r P‚©B8Ê7©ƒ¤&4­êmÚçŽ£pê§À.ÔXÀ¥ˆ(Aã{¶\nÉx@·ŒQ¼Bõ+(!&/sñ–0HÂˆ¸Ð9£0z\r è8aÐ^Žó(\\0ŒˆÜÉ(Î¦3€ðü Î0^(¡ð’6Ž\rÂb:xÂ(ŒÌJ4\rã#4Îm¦(Å\r\nO £è€Êa”ìHÂ8'ÌbŒ#Qj=£C’ð7/jð¨Œªœ’OŽ\\\"¸§	â¤ª,µŒ ,É¯|XµÂ¼öÃ:\"ÑR(ò:6BlÁ81óŒ·AJJ:Åâ{7Ö#X@ ŽR„ \"K#²ÂŽË`êç\nt½2#8ÃZ’6ð{_TŒ³ô<äM%0õK¢<Ž¹ê\nÙ)Œ/äióç]á*Áƒª¦:¯£Ëq·Í=hÍAíì§G‰|Hc\r0\rl[ HXônùÕ•usY¤òE_æµÅaœgP¸AµÈëRveš,¹Þ%)[oQ¥4Ä„ m=ÆŸ,°z‡¬kUšå¡âº4 —RºZ|‰@Vsá—p6DÖ²y´CxÌ3C“ZNaéð×®,Â Þ¹ÂãpòF#œf1³˜Ìì„Îac49qcÎ0¥‰e5'C(P9…)<E«H0ô¦)ÁH@580ê€ä6§Öä`)\$l“ˆCºócH½1Áp‹¥6ò‰òN*1£uäÉ/ƒX¶üÒ#ÜÐÆã Èî*„¼³-¨¡|™Í¥@Ði=µ£Û„fq3\r:¹ Ø^ f&&h2¼4FAezJpú\0 šU`9‡rJ¢ƒ(x¬2†GxûrZK‰y0&\$È™“BjM‰¹8ääJvOÍ='Äü”‚P…‚¢ŒÙ9&ˆ4˜PàGœJDì9?Ò:¨•q¿‡(£ä.	óÕJ/\\4 ÂÕ‰ÆÜÂlh¢xr{®þ‚\0ÂqÁÈ7\$å±,Ñ\nHCDÍé¢i`ŽÄ\0Ò[™'\n§† 2êDŒÃÂ\$)¬…\0d›V((H×`Q]²þì\0÷²žaU¹UAã&¸Ðt”X 2a¤Ê’.¢ƒ%†dÒ™\0ÞaKarð•Õ.â<ëxi\r¨pÄ5XÚ	a™„¸ì|ˆ‚¿iñØ²½G¬dD\"+r=)lv\\%‡p’CÉ\"¶\r*(È˜UG\rÅKÅu¢×¸‘#â†LC0Æ\\”m30lË·ñaÉ±x%áo\0žÂ¡²#äÍM€ò{˜IlJš™õˆ³Å#I¬9wÀ{ƒ¨yèÅ²2¼E ¡òŒG˜7sOÜq‰ô7¦ˆìMƒHg‘î[#ÝèT”qEM)‚¸AM ô%F‡&ÐR‰Ü)užVXƒç(±;jä ¡pÂp \n¡@\"¨]€H„©eáãVaäfÌü¡ÇZAMw¯!\"„À‹_ì\rƒ6Ã+ó\nÉ±öD%­\"šZ<9•,GhÄ¤›¡¬çÌäÖsP€BF' âœr/KàY¶myOšzâ‡šéS@Ï(O¶»@[]X§™ä\"‘4¢àÔ™/ig”¡fúMÙm7]š(ÖVÒYEf³!’Ênª)€bÅ†²ö¨Â#üEñ9 …R”+šˆ’zP\\þiOq0;Ôôä-ç.Gà•@œÂÅë°•òsŒr®5ÍXWT¦‘•n´êY¢@àém©!”ê]	œën£MBäžÇ™‡ÒŠ2¡”;ªAl©…â¨ˆ¿ó¬Ô‘XD!\nR3Õ^®y‚~¶ÒÁÐÍ}öP•¥úÖÆ‹qÀ\r6ã0­ÙC†b(i©Ÿ\$ œ‚Íá4©‰¤µƒ‘ŸškØ'·šÒ	z5>Y©OÞÅ`ÑÐðT\n!„€AA	y˜žFŠ~‘;WÍ&9é¸:Òäž”Öp/*ë9–©å˜³“AÃÔ¦MÓRx‘^Z›Êc4‹è”pžQZ¤ÂêµÙ1¼\0¸…=8³õˆ±y ƒZF\rm‡uÅrŒZê×j«=°&ÎÃÎZësÌvêJÞ\rlœÂ—RN³ƒžÇÖ~âl½šáØš Øî]²7cÌÖbŸní\r¿¨¶ý\\@)B¹)\$ÔŒ‘·ÔD² áÄ¼€í‚d«J l\$áM£=:†\"\$ËZY÷TO³Oâ)OlÍù³¶ð\n	€‹èf\"\nŽˆ:uÈ>Þiwÿ\rƒ35L”	/QTªuVmÍ÷Ê:˜ˆZ9xzˆ#9È­…Ö,:Àˆ˜«áV?w¥/XÈ¹9›ØÝµÚô4T;0³6;PŽƒlÇ\$©È…=8'r	¿ 8(Rn‘’õ£\"Úä2øˆ×šjÈxÅSk›]Šó¾üd¶¦Àem\$k%5\$‡…á¯´ÎÁ‰›v,'Ã­‘!‘˜^;Õwz¶Ú½\r¨Ÿ°êÂø¯¡±ž¬{»ÈPû‹ü€nïÚÝon§þºø„·´.ÑÙ[sAæ­—CÅ_—õ>×løp¬8\0Ãr’ŽxÏ\\»ó‰ýþO¶¦¼WÝPàlÊLVy7¿°©þñbÚ|0¯êÛ.°ËmžŽÌºkNª»ð\nËŠ×O¢IÈ­­L¼l†Šû®æùƒVÊcˆŒ¬¬dÂä^¦ÊB†›4õ8o Ø‹ïà}«5CŒ<ª\\¼LC²F0\\SãÝ`ìùJ•	\\*¼Ö°(‚P,l,ªK+Ò.L°Éåd´°FÌì|È„7Ð\"íÎ°åJéÌ‡nÒuPºÈ/.ù/¼î«Ã}ÊîÏÐÀûú0OÄúP'\r°åÐ6Lü(p³Ç\r‡’½æFZk`\$,CÞBìöhMÆŠ¤.åOòýo®ÛQ\"ÿp²úoÔÿpðûà^´\"¨rFPæV@²¦d\\€.1\n!Åä\r%éÛ¢6EÑ`û¤BHCh#bð‚DŒ€ÈãÝp\nÉqjîQ8ô±P±pèôŒ–¤ñF\\q‰\rŽ™ÐÞíä¯•\r¦ÈžZ‘©LÄ[Ñ„zñÃñ0éÍq´ÌH³1É/¸Š€FD;°â-Fäs®À@Cçq/£°FÑþùã/˜æg~;Š„mq*Eåx‹cÜRƒ\0`@0((\"««Þ\$K{!­£#,(Y­v6%^¾\rÒ^¢8ž¤zÏT,Gã6O¯öY\r7%J‡#oæ±“m‡\$ª×­¯'®¾yÖg±q.Ú)…¼Î¡N%ƒj%äÖ\0†DÀØd /å~¨±:ªÇ€ ÀÄ‰‚\n ¨ÀZ~\rÇÎ¼ŠÜå\0*ÂuŠPk+‰\$Mç\$­¬ê’œHC’kMälBæ¼ÒžOËÀ‚Å\r ÍRC‚ÊØ\$ êl/5)1”=r™.2ž&R¢jb˜YìÚ<B|iæh>ž¤)¸a…¦ŠÖ\"é¸I½\n6ƒš1*8“q\\ïqz7ÒR¦VÈ£Ê&ÀÞk¦é/ó€ëŒ¹£Ï%ÓŽ`-Ç&%l)0ƒs¨è§*v c\$\"0ÌP´î¤|ãá°¬U\$W9ª]C0Ã6Ð*¶/\\bñ,`ô¶SèS†à@i.²X\nÜ\nÈÎ¥°/¢;Jy;£D2ì p4SÐ9ÅÈM`èéc{(àŠ5Óõ8”4¹†Zº«Òfb/9&Ö-ëŽ´³ Gñ‘=#’2©¦C¦’“`Aâ8JcSÀä";break;case"uk":$f="ÐI4‚É ¿h-`­ì&ÑKÁBQpÌÌ 9‚š	Ørñ ¾h-š¸-}[´¹Zõ¢‚•H`Rø¢„˜®dbèÒrbºh d±éZí¢Œ†Gà‹Hü¢ƒ Í\rõMs6@Se+ÈƒE6œJçTd€Jsh\$g\$æG†­fÉj> ”žCˆÈf4†ãÌj¾¯SdRêBû\rh¡åSEÕ6\rVG!TI´ÂV±‘ÌÐÔ{Z‚L•¬éòÊ”i%QÏB×ØÜvUXh£ÚÊZ<,›Î¢A„ìeâÈÒv4›¦s)Ì@tåNC	Ót4zÇC	‹¥kK´4\\L+U0\\F½>¿kCß5ˆAø™2@ƒ\$M›à¬4é‹TA¥ŠJ\\G¾ORú¾èò‚¶	‹.©%\nKþ§B›Œ4Ã;\\’µ\r'¬²TÏSX6„‹VZ(è\"I(L©` Œ¹ Ê±\nËf@¦Ü\\¦‹’š¦.)Dæ‰™«(S³kZÚ±-êê„—.í*bÞED’¡~ÈHMƒVƒF: ‚£E:f¡FèÑ(É³ËšlÉGÔ(ß'R½’ªdX#Dš#Ïa¯+°a P ó¼ÖøÒó¼’ª6ëJb”ÍSÚZ™¨Õ1D¡tJ4MM”õ'NŠ4O²jÊ@£ˆÑ#QÔ1*ÙÕ&GAšCá[¦%àNÜ¦‘„º½’\"èGAàÂâC(Ì„C@è:˜t…ã½Ô# Û£\\7ŽC8^2×¸ðï\rÃ˜Ò7ß!Î	#hàé\r·Àèã},KÀ7ŒŽ»²9¹˜¢&\r.òÖ€ªeŒ_7iŠ\\KY‰th%6“ñ\"RdV Vt¡«õ‡’GÅšFÜ·yÄçÚm‹@’6m°Ú¿é*¯–&3J‚\nãä7D:2â°rÄ—:âÐkìöÃ®ì–J_9–Uzš’\$ltLê™·Rr\\ÏR™A HB‰†ó—6l”›¨dMõy)oH|\"[Ãê6\0ì0ƒ¨Ëä9–¶5{‘¢Ñ®„º5À5TV}tÎS)fhÖEF„`[’–µTÙµÖ“äÊÃ¦Ê•ØH~—´Še+qÔ›\0©%ƒ:‡(„8h”¨#rcc®òºHÀÆ0Ðî7¥z‘S›xÄÄôâRúuM£Óœ©?ŽÇQ©ê^Lª:&kM\"R:õÅ	4 É²ñ£ŒÜæÙé5æ šž*ÄVïÁdCØé†€†TJ+3XçÄª?.°‘™>µ/•‹úZ(9¤:1¢ÒÛK-Êž\r@„ª ™›EfÉ—œ rGáµcÃ0f\r‹Á´ãZyË\r¯<‚\0ê¿C¨cgT9†g&`oè€9£Àè¢èaá…êØ—xn§x0RZÌÑ»Ni!/´à@Â˜RÏM•7 \\AãÄ+©L£E&#±+…”hˆ’	X·Š©¨ƒ\"Vàb´”&¬±à«#l.	àT8¡¸5`Ì½\"òþD € ®åà‘àc`ø2/@¶–âÞ\\œàÈÀëYaŒ8µª²¢]{è…LèÈ’TnTDb<EÎÑšpšÑÙ6V’AIiÊ,¥jCSòmÔŒOhagx9ÉôÃºôb¡”<\0Ò·C\$™¡n­õÂ¸×*ç]+­vÇ•â¼×ª÷_4~/æ\0Øs`Œ„0©¦ÃË;¬MŠ†\"CYÈc§1xÅ°ÜÂ¦ªZÃDKŸ¤TTÈk'le=’æ¡Í\nV\"Ä4€ÂÃ¢ÿ\rÀ€;¼Ž@p^2Ü90–*C4ü#†1‡8ËãLkªuTðzšF	Ž„0 ÒæÉ™‚‰=–8Ãf¢Œa7Çô¤¤¡n€H\n\0´þWÔ§_ÛÒ5œ£É:RŠq¾FŒÄ¡ÔAÚÄaQó‰ÃŸäÜ‚Aq'\r€Sz ÖX±Ì9Ç@éF* t:Çˆä†÷*æ#Hw´&½£÷¢\"¼!âZÜ´{ÏéO-iìÄ\$CtÏ“Ñ …\"§w.Q\r‚¦õŸ”ƒz›¤Ã%º®ñL³±O•Ûl‘å¥ÎY¾ŽITâ~iÍÅˆ‚»%ÒÁ<	\$\\<œ @K9NUŒêZxN²Ý.j}‚\0Ìƒxm—’ú›ÏÓÀ¾+œicºÞäOCÿ’N\nT¦¦ÖI\$Åg§±ybxS\nŽÞÀûæýìþ×§ãR¨Aý˜¿n(£»‡O‘…ÈR-¬¯²[ B™¡%2ìA5·nIP;#u¢\\à`gÇTÎÔi] m† ÒÁ	˜Xèœƒ ¶Â0T\n³Gf\rnc³•ÂødŒ/Ž¼kMdî2¡&²gÓ“(…m±\n’²\rS®\nàÓ	‚zIô\"#‚fiÒ@DÃØoã@MRG5z”\$±à¤R~Í–’5P¼4^¨’/yÄ-è^\$XS³Ã5bË»6ƒÒ©QAe¶|^º¸U‹UÐÔMªA–,sŒ”¢ÀÕ8®	«z/ïYÁ\\z!KZ¿Öpaÿ¬J†‚D¨*ršÈ‰bÖòô«‡/÷r?˜	„~“–^{–fÛgæø]£øèéÓl€:e¿@–øÍD\n#Q3\\Ü¥€u—,=‰±v5(ØóëPZ7,îru,„‘*‘º\\Ÿ™[=‘´Sìß>Ö`…ªN™RÉŸ\$ÃWH‡CHzsv±ƒG·6Ã)ÒªqïÇãqT‰¼ZÖ*a>êñ®ñO©1S C¾ãgÅÝFèLZ9¢ÓPˆ†”Ì°]Tã÷h{˜¹”žýwS{ÿAj‘q&àF…5ü(üm¢&[©¹!)ÑRNåã\rÕ²fƒŒùV)Ï/²Ú/£Ú½ë(K|<æéNr¾ëÃÈ-°0¢ôýwö÷ÈB\"\n‚Be3¶ž(\"[îa	†,‘ p·¬ïSŠ+!P*†íGW6-Û{ƒÕ¸GzâlöòTÉ\":G³iõ{–ÄËÓbRÔ¦‹¦Î7ø2¡pÿïöd«Èm¡ ='Ò€môË§¢CIÔÒbèJiì¿B¨ðg˜\$ïôfOøe@\\0j0ˆ…¼P ¨‡„ó*C'ð.0!f€L‰aS\$°JâO2Ñ‚?ÐZq°4b°\n}îŠ\nöj@FØÂO‚›Î`âxlP•Â_£P#0&CP?\nÆ[\r¾\$°rTðv*½Á}&»oêè°´n0¹Ž‰\r‰GËÄ5¦8]ç*Ã\0î#0BÒÆL†dÙ‚ÂY\"FA±ùãbøP¦“\$¸’¢\n›C@èyj=	ZU‚U…-‚Ül¸ìeZEÂ…Í új?pÔ*Qcä5dÒàÃàœ,HKàTà†ÆüÝ	Ð¯¯°Ù…&É‹Ì•cƒC\0B44nŽÛ	°E‰ºžQnsãLøäñ'¹ñS°-î40žGÍù,S	bƒ)NjƒÑ¼jA¥)ÇQ¸†m/BÖéˆhïAK1‚bÓ	í.ðDÎ0‚§fœÐY£ ŽšïI³dnÖ¯¤‡˜ìíd×‡¤†nòi/rfÌœY\$c\$y„}	´#Ä6NO°éB¨@ˆÃ\0àK\$LJ	Û Íª0â5&æ F‡L­v%\$à¯‚S(~fðC\$‡ñhBðÇ¨ÚD2\$ÉP.€QÜLÄÐð®û*\$‰)N<EB=ƒF“\0P½Mˆ\$«Ä23(ˆ†ÞQ„¹«ÝÑÆD’|ŽÝòè§Í¶Ng”èáò”.	/’«nŽáK\0#íã/RäUû’ h€ì©é10³…ó0à’”ä+1’ñ3ÈáÓC*ÑÛ3¦@ÑÐÌwÅ8FMðT\$|2¬^eqLøƒøÉù+ò,ÐßD‡2b·2³e!P¡6ìU/Š4êˆˆÄyS„ð‰*ë5r'9s^Tè+7N0øó£7ó©­³52’±3£Òóp¾dï=6Ï@ó' \rË+3Þ!m‰ “èÒ¯5s-3àÑ“þóô3SFV2³,&š×'\$|æ˜ìÑˆ)¢®.¢V*¬b*B2%ˆ²ÇH¼£,?\$+B1}t*öçfd“Ä€Oz¤Tùë˜Be„\"H6æ€7¯`»ÉÌô	.´TY-KœKÂì„âÅ4?Å	@~Ò òCÖ’9 ÍròÌÙSa\"’ÄAòÊîF~î´8ÐÛLNè7sï.Óó5ŒÁLtÕA“AÓ;,3HHˆîpbùr€†ôÖßrï+1O±û=s‹=´Pb»P³S1Ha\"ÓÝ;*MQ“PŽ\$Î'd—Qg^P\rlE_lW¡ V@1bšÚè6.„ðä°¯å(JrMUÇæÚB(6WSÇ7¦mOî SW3Ÿ<“4¹5TÌ-a>âóxù{NUåõƒ0‚†At(Tu¦–ðHOÅY³¢‚R+S#ñZí§[58ú50M²wY“¡X²”n¢²É=	ô)VÂâ´DõŽ'-\rÀKËAWÓ9Q#!U«4EMzËÓQ´½4•`µú¨ÕÿU–PÕ%4µ¹Ñ‘b)bK–½/Nôacm@öîæí`U3µäòûAµ!@¶3Rg¦nÖBúfŠMèõEeTÛ@¡Eg‚½LµZv‚HCìÚ_NvcZvfðŒ©Må]]VDõ6ô‚¼N£&ä/Üù…-TÏ¬½…jP|é4lÚúãYl–-@•§meI»!QÕÇ1´ÎJAä¦i°ÑXSw]í„ÕRp©jsðkëRe}n©µVeVP^kµ¾§P>¾“g	ðÇr39×Z´—;w3qñV¿Å~ž×>)ÕtøÉ®7æÜn’V¥—\nÎŒ(õR#ñ½sŽ]]·Z§Wt³Ù;7U<ñ¿ró“ux‚•xÑátw1—‡×‹83Ð¾@hÞ\r€Vóî)cì\0Ýf¡)•gFõê=R[¦H'MÓX ŒÎ¦\"¬*«ìª`ª\n€Œ pð˜LD0«9-+Aƒ|#ÈXÖÓ p	€peeøS-°pR§8ða\0000›€ÈFwx)u¦2T&L^pdHC2#Å°	¦(\r Ì\$Ež7BSƒêD¤IE95¯«m85e”“ø\$ö\$néBm|ác}64BOŒž£'\$®”š¤Šo¢’nv\n†p¦@˜\rìÖ\r¥è9¸<˜µ‹—þDE[êJ-ðÉ®>îøSEsÖ1\$6i=+1õ#¸áa…2âUó6Y ®œBxõ†¢šè‘oØÿçIÉIM–Ì©xÝr=BóRMB@?cá;5*y!+YE.g´à)…8gK¯q”'§“áàòl¨Œ…\$N|=LŒÆî€fÆ¢ÆÒ¸wè£]J_*â¢øÒ{)¶N€¬©àê ÚØù0³£}Xttð™©v„ÊÛCê}¢é]„Ë5¯‰Ž¾çÑ¦B¹Ë›“Ûª?Ò¸qƒ§¨,T”E•ÙÔq¹ØL¥\ráš¯Ü.¶;a¯²z+S\\xƒ]DT?SÖ¸dà";break;case"vi":$f="Bp®”&á†³‚š *ó(J.™„0Q,ÐÃZŒâ¤)vƒŽ@Tf™\nípj£pº*ÃV˜ÍÃC`á]¦ÌrY<•#\$b\$L2–€@%9¥ÅIÄô×ŒÆÎ“„œ§4Ë…€¡€Äd3\rFÃqÀät9N1 QŠE3Ú¡±hÄj[—J;±ºŠo—ç\nÓ(©Ubµ´da¬®ÆIÂ¾Ri¦Då\0\0A)÷XÞ8@q:žg!ÏC½_#yÃÌ¸™6:‚¶ëÑÚ‹Ì.—òŠšíK;×.ð›­Àƒ}FŽÊÍ¼S06ÂÁ½†¡Œ÷\\ÝÅv¯ëàÄN5°‡SÁ«Ü“ ¹»g	“¤pä7±®úvù¾#ô]“áÒ]“+°æ0Ž¡ÒŽ9©jjP ˜eî„Adš²c@êœãJ*Ì#ìÓŠX„\n\npEÉš44…K\nÁd‹Âñ”È@3Åè&Ã!\0Úï2Œì0ß%Å¤‹öƒb‰ÀC@\$)©¢Ô¶H…|™';• ˆÒlœ¯±†üI¢jV¿ªzT·\"ŒP¢iÄö2ÃdPC·&! bkëèVŽ\0P2Ê\rENiDþKÅÜÛ2°(c@ä2ŒÁèD4ƒ à9‡Ax^;ÖpÂ2\r®ØÊ9Ãxä3…ã(Ý^¥|90\0^)ð’6Ž`Ê6×Ã xŒ!ô'#¨èÞ2#ƒx@:Žc(@)Š\"`Óa%ÂÅžõ²¬»3-Ðh Æ€”±Päa—HlpÂ\nxëEe`Üô¹M‚ß&°î+Œ#ÜíŒè KnCÍ„aL@ýŽÔž¬D¹tš&	“\rIªIÄYA‹`‰RBcú;#`ê2WS!ÀHJpT§cvPÃ'ªìth©€ºc[‚_±KÑJþÞeÙS(˜erÁEzP<:´l€‘:l¡tøÑÑA6’>ˆC,Ó P\$ƒµ&¼­òÚ‹+ålš(Ž¦RþŽŽñ@‚-Ðfð½½ÚË46)²½È&CÅž\rÃ41öXJ¤‚¦\"rŒ?;(è© æ™Yì*˜[ÝXÑÖãeÕêÿ_	ßEÒ\\T]µóR‚Ò¯\r”NÅÔñœÄ}¶;×”6ób¶sÜû]=Ü“7\" „v]§,ÅfC,ìÖq\rã0ÍA\rÃ*–4;Å:Ð qù†Z¢c\nH\n)\$)ì|¾wŸ‹pqè.(Ññ=N@¬?Ó4ÄÁó_ô7PÂK’\"iÄàA2ÐPÝRÏô4ÀØ‘Š•%),’\$P ÌÑúB¬:’å‘VÑß?¡á\0wæ•ƒXs™]-õˆ]‚\n´VÁÊ†4\0±\"·\n‚*5J²˜\"Á‘\0èÄšÕ%Á@4”ÐQÓ;E4¡„4}øt…ÈeÏ	PfÞ<3+9§SèžÄw:§õ¶’Ø¶¨bò¦U\n©V*å`Õ”R~*á]+Å|°nX‹0ãzˆ0¡&QÀ6Æ•¬Ë	c{MTHºvŒA.=íœùBFâÓ¡¡ÎQ’×6¸ƒcŒè\0pÒay\\AÁ[ÄÀä´àaË90êÃÃa˜:ÍØÒ™Ätš.\$´*£‹!º3³T(bÍ\"ƒ'Ðø¤dü‚Ùl4ƒ7GP.…¹ý\n (Fžfˆð—?Äá\r%¼R%Ò\0~3)ˆ-Ø2ƒIÚYÁœ2­Àà®ƒ¤J\r1(7óúÍg8w¤¥.\0¯×è[ácóiçö\n(Å®¼åáçDÄ‚à@\n!úÉ¬]Š3û,›\\IpuŸê˜'K±Å'éD¡ÑiöàŽ!ÿ?,p¼Ãxr@aà)%Á\$‰—ÒzÃJÜ¥§õp†å¸GiZ\n¦¢aŸÐÌÎœQV²nv¯)Î¸htJ†’àˆ»T™\$'Ô¢À^xS\nïÃ2s#‚D|S‘~²RfGja:'„¢›Ð‚v#ý@vä]0Q\\“\$¤V£?TçÔ#öN_œRzJ‰aëMåØ#Jsä29ëyê§Ã’Ÿì‚ƒ‡¨žÀ;:F˜ý»-¬#!“I*>†\"é:^pAúg¹-Tþ9°ÂtÎJ:PÇîå7CˆÅÙL‚ìF°6bN¡ÂQ¨„ÔÂB	r\n²÷%Œ‡‘ò0k#a’Ô¢c»|]ØL§7rUC\"[Ä·½ïÖ]ì‰¥Ik{¥D¬LÃšYÁ\"ÿ°bgÚ~-&„©{Å#uÉzhM	ŠBèheX+\rb†ìšÆ@PV/ç¯‘ÄÑ•ÍÑE:hµÛ÷‘Å\$'oM&„»LM-I\rib·¢qYËõ:î°6”8Ñè¡(ršFen§Tz¤§84†Pîb×ù³¶Œžâ<\"gñÆ_F½Ÿ½0Î:;ÀTCòb–—Û®1\r5ú]ðÏxQ0xWY®hÞä[Äª¬²\\]rj	¥½+¶d˜‚“éŒïÄŠ#„YÉ3±ïjÈ½Æˆì-WMÉÀ¨C	CÌ0@úÌÝ.›ÁÂ“‡%„%ÑxÐh”ÿDRîÖ¬ð‡Çð`‚Œ’Iµ%L‹wn6Ž+#P4·“2jMÐAvEÇ‚AŽF±ih„1Y-‰ÂàÐ9x‚]6øÐ{è™Çf|@ ‰päÌƒæÊ¸:ñ7A¥ZŸÓþÈ£¯¸¨ZÊ°<ìÕš\rC\$Oÿ¢aPâD[ÄvÁ¶Ç\\¶RI«oHé‹N¦b™ÖÅÉëiŒ&líÌ-ZT'¬»ûÑ¼‘\"&èúc„o«<‰MÒ/•g\$Vç›ãªl›SêY§‚_C„‚E½\$¢õ§O5]·î0òî¡ŠÎù.Ò¾THùNçÐÿ›Å¦\n;_Œé¦J`à*êòñ~JNih2­¦Îû,U…¼uJRß„CþJ\n@?Q±¬¯(ÚÁ…Ð±-ŸQK[*’ÓK¹0kæÀëÂÉ”µAb-“>N?£>”äóm¬4ïßÓLmÚ‘îÄÍý\r,kétlcÓÑ˜ðû	\"ú¼¹,Bñä4*ç¢ÆI\0Bhóïvt	ðÂ&Ïˆ>ÿÆp\"vlû;GSçZ%ÀŽÎäLà„Èíþ­–¨hû®,2.01gê<¯ÐòÏòðÂ\\\"Ðf¼hüOÈzã	-Z\r_®\\ôŽ ôËt3ÃÞý¤~.Cœ7ëè?¤0ÔéöébîNú¬È@‹(âjý-2ü\"ÐÞÐ¦k¬º\0{e	#¦&J\në(8¢ª·D?M\\Ö&6PÐdÇM¡vt6:Mt¾¢,Ò)\0ÇÐ}	/Ê`°…cPlÅPpÒ\0`Q¢Nv*Ûýæð°f9-ž^04s‘‘Ig#P-m ßCÓ‘`çG v&U¢òa_\n„¤lãr	mr:%òIAvï,€Q†d@Æ ÈxbÐ`0(ÿDÙEmð9\"IðSÍ±‘®¾ÑRmŒÅIm‹„âJÔ1nÑË®VÇï²Olê/d/cœ5d¨´Kòÿ(Å‘§\0…¼2 zá#ø(rGËòˆñÆ¹R\n¿-¯\0¨í!‚Õp ÚqÐ#K¶ð<{%»R&[Ò=#gÈ\nl!\r9%L.Ir8[Ò`½òd`…ù&²X<Û'D–sdØ\$„€SÍMõ%\r\\ÛK”N\\`­²â6>ðbà’)òƒ)pb„/¬¾+BŽ,½\nÆÁeè%PwãX0Ìâ€ÒÌ`h0ŒãªÇ«jÅØíˆŒ:àÂº‚.%)Ôrè!ÊLŸ‚åÐYä>	Ãè¢bÐš+ jHäËd€ûOò–n¾'²T\$ŒÑ+dø/O”4¤DNâ\n ¨ÀZñ¯€¹N\$PØ»bè*%2\$Ç6\rªP’p0§\0JÊ¤\$ÇÀ5ñ÷BüJèÓ“-0¯ý2qèûc6(£j,àäJÄšl2ÃÅÖ¨†Ê»%ÞPÓ¨3d–Q§\nolRþ-p8CúØ÷n\$ó¤4òâU+Äðbóo4¼Žüq²ð¬\râÄ¬ÙÎ£¯E?0~«BH7îò¢(Ñ>ÒL|LáXi¦Ÿ;m¨»Mê@4\0õdôOJõç27Š&<â_\nËPâU\rss,ßDâpµLýMBÚrF²OlÃF–®.I­¦ÅæÌ&”-T7†\"ïª€\rNDèH„Ó§7m:ã\n	ŒÄ ŽÒÌ*Q\"Jª/ZºóqCF•L(wô°(\$L;û/Q÷\"2.¿j§ŽôKL´3¥2Sr†Âæz×Œ~4b¢";break;case"zh":$f="ä^¨ês•\\šr¤îõâ|%ÌÂ:\$\nr.®„ö2Šr/d²È»[8Ð S™8€r©!T¡\\¸s¦’I4¢b§r¬ñ•Ð€Js!Kd²u´eåV¦©ÅDªX,#!˜Ðj6Ž §:¥t\nr£“îU:.Z²PË‘.…\rVWd^%äŒµ’r¡T²Ô¼*°s#UÕ`QdÞu'c(€ÜoF“±¤Øe3™Nb¦`êp2N™S¡ Ó£:LYñta~¨&6ÛŠ‹•r¶s®Ôükžó{¾¹6ûòÙÍÀ©c(¸Ê2ªòf“qžÐˆP:S*@S¡^­t*…êýÎ”TyUëx»àè_¦\\‹¤Û™Tœ¥‰*Œ¸©Óªë¡„ÒŽÆ'ŠaÊ[–Nb¨Æ*¹ÎVÈÉd²>1[œå‰vr“ËqÌÃÂ¬!J—ç1.[\$¹hŒDcðMœ¤Al²¤‹‚N-9@€§)6_¥éDï’ë£âs–eÛ‚‡%ÊyPœ¤ÌŸÃèI´ä1ÎP)kÄ ¥Ñ&²1zJ·g1@œól“8ƒ\"9£0z\r è8aÐ^ŽôH\\0Œƒk¸2ŽApÞ9áxÊ7RÃÃV7cHßLJ8|\$£ƒ>6Òã xŒ!òŒÑÕ\rhÞ240æÊŠbˆ˜4µm©Ò@'1TÄìC–“ñÎRN	&sÄ#lWÄ¡rtä4Œ_Zv­®º©EÊ]—V,Ð\nãä7;ƒ8æ‡Ö©ÐE%‘É.²DQ\$LY•IE<¤9Tr‘EAÊQ×ñ“èÂ:ƒ @;#`ê2UýƒaÈ%í‹Œ“vÑ D%¤8s–’ZN]œÄ\"†^‘§9zW%¤s\0]aoŸœ<¤a#Fiâ\\VÖM–]<D„sà…B Ø€ØÒ6Lø@9ŒcÜì×G)\"o#üIœ¥ãÖå7Ó•jZ×3rÍVîÚTKæÇ!Íºl¸^Ý4Ùå1tÓ)ÌNzLÀ^:<YÊC¬ûÅÆ]IÓ5ÀaŠN÷ºç6„TXˆäÆ±áÔÊã0Ì6Qí©Í~\$£Ö*\rìÀÛ­!\0ëN£ÆÑc6 \rƒxÎîacH9w#Î0»¢Ö”pÜ:µa@æõÌ,ND¦)ÁNRäI«_ÄjIqä~š®§)JÁ‡eiDQ>c¡’\rÁ¬Ñ†e&î”éÝF¨ðäòƒŸS¡‘HòžÓê(àˆE>j—j«U¦Ô)¼<GàC¢Â›í}éÕ7?‚îCs5aÈÌÃæÔš´¡à8”øtOA¡>'å\0 ”\"†Q\n)F=e ¤”¢–S\rM©Õ>ÕsTj•Sª˜D«Š8 V!¡Y«XÔCY•W†eH;pÜªa\$&Sð¤_ˆQÒ(EØèB¬„ŠóÞ]‰d2¡„1‡HN¹žjaˆÊ‡!ƒ’¨V„3C¶®ï]øsx/\râ¼xQ\$Mi¤\rT9†PGU!¥Š‡7\\\\‘þ@·—8°D ¯NIÐ\0 € —H\"ˆù|`ˆ(ä0D˜À†§ã¼]±¸ÍÃ<h*´\nL:3^eƒ{b¯;Îºa„C© Æl!aa.&ÈÀ“RnND\"Â¸Z¬VU0·`ây‚\n^cI.”2•heØ’·\rÊÐÖÎtøX¼:˜9ðÛàlw‡†µKËŠ­åTç82›RbÀÅ!Ã˜¡@'…0©2“9Š*Î<G”\"ßÐñz…ÐÕ^H…f,Í¯6Hcqk0 Ó¼Ué\0b\r!œ+™Hæû–€€#I’Ö• iT³‘é1*IIšº2ŠD´\nA,ìY æ	`W‹Âp \n¡@\"¨l=‰&[Zh— bÕ/ –-\"T_·LÆV°ÇLê—AsÌ‚#àEQwlÄ]¶,‚œ]ž&Ä÷„¨ˆoíÀI¡D ŽO	ã¸i¨Æ1§?rÓ[’oUÌ#qÎ*Zör£”G‰†YQÎ	–4¾›„'b	šbðF>cÛ!æ8P™h	W¦Èk!Ðð·½K½‹wÞKlå°§•p0Ò˜Ä×T¯aŒBS?#g	ß¹'t‰Ñ<ëÄ«›o¦2C¹hë0B´3¡”;žU²¶ð\"Oe-•86µ¼Ê,%¢èHA6µ\0‡nVstF\"…1¯âQš-MwŠY>7IÊ\n|ŽürQhbèƒ	¡Ò\$ÅðæÆ½¶G!€cv³BëÝ–x~Î¡(rËŸ&_„>¬pT!\$\n@¤I¢tÉòtQ“O8Ã‘«‰´OŠSÍŒ\\ƒ±+ÀðA£-v„ÐÂ¼QáOkˆ5¯âV½@A¦x—I\"Är‰1ƒ%Ä¿ª¯žA\n½-kŒfžpåÇBèxTÿ\"-:\\P¾²ï«õè\nWj9‰RPî»Ði(#ä„P¢zSm¦ÌÕ£ÂÈt't3J¬,%¥ÐCÛJù+d‹kê~…®Ü©¤	A2‹…°å\"ps\nÖT.Ä+EYK3Ea^ZrÚèlsˆüxËÁz/†~ˆ<—qÏ¾µCŸÜad9„Ø´}üOŠ—}ntÈ/q&“¸¶.ZÜ£’¡Þ\\¡už¯ÔH%üX9„˜Žc\"ìLaH9D\0¼a””8*ð~wÖÐŒY«åôËÒºwJ³½¡B®T.q†,1d^	TBˆújöš6ŽÒ‹¡M5G5\"¢À´rk}t8³íª©{¸rÜ™ÝWªêýã¶òì'†›·îíóÀòÞ÷á|õCæ<ÊÜ~­.CéÕikµn£ÔºŸ»qÇ¬)í°\\ú‰à¹{“ôÆ/_ãEì9DŒâ˜àCúøûÑ…¿ÒÿŠ‚ì‰Óëëê•1Qììµ\\Ž_o ’«®\$S~FD¦,ôáüôFoPŸ¯Ö{G+ÕËC¡«Û¾õu°¶’?¨äøŸøùÞaûÖÚõ+“ü\$~ú¹|Í˜ôOI\0BPõa\0ÂR.î¯C¿!tÍ&˜lÂØ-Åœpä¨æîË^”mrÿï<çáZÌ‹°ò[Â¡Ìñ/ìõPNñæp1Ž®qæ<0ìv…ŒËïTðríŒ™‹°<¡~û!6Ï†ì.Üóæp^ÐõPžùpVZÏ!\nôpY\neîÉ®ùpHÂp–p¢\\ÇÐ´ZÐÇÐÌé‚Ü…P\0<lŒÉ•\n¥®ÉÐèKPÊÉ¬žÉ0õ/Il ÛÐ‡>-àF\$gÐá¬Üðíð÷Bî	r•`ÈñÐRgŒ´¸G-të|Ñƒ®ºË°Úav¸Mì¯¢žGBÐ¡b&ÁB(Ñ281TIm<:îD»DÄ­HÔÉ¬€ä\r€VgX`ÖöOF(bÃXvÅf\r Ìw%x6 Œ­ ÚªD’‡¤…\0ª\n€Œ p.‚**;£jÓÍ0¸á^qƒÂ4#z¹Å†<Í\\\0›q«áfƒ”.!ßãŒáC’½ãá ãÊì²Ëg:PÒZá^®¨¹¡B¬*Iiô!.t	€Þ«àÚRc*5#bØRC#¼?Á\0.P.Ä€Öî,®b‘úz‹lå‚XIÐà‘[nòïË}'€\n†ªÏC\$2ŠÂªZ\ràà‘ÅÄ#k'Ïbÿ¥¸øÄœ@ÌdÌ`oâÐë®pçFþì‹L,ŒVë²ÌìÌÖ1RhF\$6ÝPt\nÉ ê\r¢0‚¤,é Æ¡ÌrZÐ¥¦&\$¾à¡&ƒË'+lG%Ä­âÁº'Ky†—\n‹&gòØøÄäö¢\$d@	\0t	 š@¦\n`";break;case"zh-tw":$f="ä^¨ê%Ó•\\šr¥ÑÎõâ|%ÌÎu:HçB(\\Ë4«‘pŠr –neRQÌ¡D8Ð S•\nt*.tÒI&”G‘N”ÊAÊ¤S¹V÷:	t%9Sy:\"<r«STâ ,#!˜Ðj6Ž1uL\0¼–£“îU:.–²I9“ˆ—BÍæK&]\nDªXç[ªÅ}-,°r¨“ÖûÎöŒ¿‹&ó¨€Ða;Dãx€àr4&Ã)œÊs3§SÂtÍ\rAÐÂbÒ¥¨E•E1»ÞÔ£Êg:åxç]#0,'}Ã¼b1Qä\\y\0çV¡E<Á¤Üg–¢SÅ )ÐªOLP\0¨ýÎ”«:}Uï»áÔr¢òå´yZë¤se¢\\BœÅABs–¤ @¤2*bPr–î\n¦ª²*‰.Ocê÷°D\nt”\$ñÊO-Ç1*\\CJY.R®DùÌLGI,I½ŽIÒ@H‹–Å‘Ð[°§)r_ «ÂK¯oŠì¼')tUœå™w/ax].J2«¥Áft(qÊWÈÐº®ëÌ¤U¢äÉv—ªY`\\…É\nsÎS ,°ä2ŒÁèD4ƒ à9‡Ax^;ÒpÂ2\r®ðÊ9Ãxä3…ã(ÝN\r€Ü9#}>)ð’6Ž\r ÛOà^0‡Ð{QW¶CxÈÔµc›4)Š\"`ÒØ7GI\\@„<Ù(Q!^s”…ÔHËkØ_•Ç1(\\¤…ÐSÒm¯lÛvZóq:,I<t”Ù6WB¸Â9\rÎðÎ9¡õØÄ<¶@æÉvlK­É‰vtåÌC•G)JØÑ3” Â:ƒ @;#`ê2Ù¶=’–åìT\\Y¤Ùr’B–HŠÜreÙÌBññÎ^Þ1IJD}šLª1Tb'1pMà	â|ƒB ËP„I*[ÊE2[‡ à#ccRÛ´\0æ1Œ#s·`œ¤‰{š<§1IÆËqÊÞ7×´\\ÜÒŒ§½\\²}Î¾Zv®ì]ÚOžû&ð¶¶û7œÄñmÃ)ebvž¥¤a_?¼ÑÊC—Iosñ\\ô¾<Ý4ßŠ)\\_ZÚ–µdd8ŒŽL“(^lÐÞ3Ãe,ÝO“ŸA¨ìèÛ´!\0ëQŽ£ÆÓŽc60\rƒxÎïacR9y£Î0»ÁÊ×t¨Ü:ß·ÿˆŒÅDBib˜¤#Wƒ]<¿>DYÒ!ÄiÑO‚ñ“ø9D°®B\" Ÿ¡>ñ\\øº2!PË†àÖj2šyÊï‚\0‚¥°r{ÁS*@È¥Á€PJC€Dƒ\"¦5ëÙY+CtÞ¢¥\rÀ\n%Œ#‘‰õÿÀ(¥2!40‡3`ŒôMaÝM+¶¦Jƒ€º¨Ð Ô*‡Q*-F¨õ\"¤ßR—S*mN©ö¦¨•\"¦ê 9ª¥X«•„5V¥ +€Ð®•ä}/éó1 à¥ÞXnVÞªhx/Ñ  Q\n±Ê%`yð‚a ÍÆ!Ð æ±#5!Ã”J½]†ÍÛ3ÑzaÍê½w²öáÜ£6F¦N6`Â«Á\0c‹JÀ4±ÐæûÈÒ@è% Ó\\„K4i%m\nñÌ#Å£ó\n ( D!PB\nA‚†‚CI‘jšEIõí Lù¡4f”2«°à¦ƒ¡¨6†l7±¦:öC¼õ™ÅùŽa\$G@­\$¬ódF Dq.&Éù¡¡Ì+…«'åš—!\0OÊ	g‡ÍuQ(…	!˜—vJ»3Œi_åvl§Úƒ,~'\0ÌƒxmƒÐ‚EEd§¦ÙWÒò}‡ÄMÐP	áL*)i@/Í(M”*é‡0ˆ\\(Š’Òul™1¤„R*dÌ«h‡f±ì©7xià`Ê}<ØÜÅ*yMŸ2¬ŸŸT\n„¯ƒ‘™S´R	aÈ/„0é¢Ô¥ŠBP‘øO	À€*…\0ˆB EVˆ@Š-©Il±ŽQ Ù=´äÉfµv²ÈEÂì¦é	ã¨uŽÁÚ'DP]žÁp\"îaâìòwà%_‘5qéLÈÝ¹,…OÉã\"È»5“w‰w¡2	QÎ\$H¨mü¤ÇP:pŠdä\\EˆÌ!KqHâ\$D!XCÔ|Gb>Í¹»2§ÌœjÙ8ÝA!\n(ºÁ!fÀ¢`ÄJ~ÖzÐ:”ÚéÊ°S\r!éNµXû84’~zžÄyHÁ»¥Ó8Ç`á¢Y¯RóábÅvhƒ(w)b©o.ÄëŠ°ç‚ˆr‹Ä”9Ã{ÊYS+Ë09…Ð\"ë½‰—\0.n%%²¶^ÌÙ³Ì)ÅÄ©~ôºK×œ3–tÉÝ<¢1\0(Ö™æˆ±ãâ1y•Z»¾bé¡AtuEØ¶ÄË0rº3æ{Q\0èD@*Ô@‚Â@ §yÓ»Å?)¡¬žáÈØE²–'Å(è\"Šžñ>:\\Ñç<¯ ð@¾Ly-âÜÇŽma¬…O	q	ôûl~Åè±\"|_ÌòæÛ[x»–ÙÍì3†Pªìeb TŽ]¼(DbWhì}f†w8ŒK	J±ª€×Â)Ä|‹<–N7Ù \$Pôs‹a'%\$°ˆ‹ëŒ–ÒîsÊ)vÉÄâ^ë\nnm‰º7Ó\$Zâk#AËÂ‡0­D´A¢1B³Ö\$×DÆý”„¸…,\\\";ÆEÌ	ƒsbT‘|EL>]£wÃÞxn¬=ÂlZ…Ó UêFuuußJIgàÝBñå»`:Ë\\ö|N“aïko}¹(w #mÚYÊ¢Uåš(…j@% \"T\0à­ùáeb7œ°4Qâ‡/Œò2Ý[ÏK{VY[yo½™9•‘\"&ñ÷Örµf°.…4è%½ß¼é4Ü”áïd¼kpáî¸Û­¥ÞÜ÷K^·Uw=¢=óMóßŠ¿wì²ƒÞüœ~[}ßrp=½×»—Ö„Ž‡éÃE_D+Ó÷ŽÌ†?§í§µ}‰â<„þËY‹4-~Ãý™³÷üËÕüÿu›29³0ãô¡\$9LÈ¢ÿé ]%Ánš˜E 9K´tÏB`ˆ„*PëÊ¾¢t°’I @óâ:L#Á(ïd@ÇŒO‰#\"¥Ä2Íoò³1\0Œ ÌìÒ1G?O0øNØ[¥¾\\\"øøïÔ¼p€ÉÐ†ø-*½PBúëO{	¥Äý,nÑÍ Ïâí¬f±	O{m\"ÿo‡\r%	lí…šËæZÇ\n¢Á^hP, Á¬\"|Ánä-¯dû­&ö*!!ÁþÌíQ	NØsæLElÎ‡íÎªHd«÷Ãæ]‚|*Q%¡6DÂEoF¼ŠÛm¾±¤‘J?Q\0[kéJúAs¡/Mëë‘G®ì+À÷±uF÷QiP¨<†Î!2Ðä¿føÏ’âQNÎñ‘Pž%‘aìòL›Ñ¨)dhFÄq\rŠ¼m0>\r4±™¤C¼½QÕã\"	š“€È\"ëäh\"–Ì\nrÇDKª×Ø\0 ¨	f`P4àRªÉ*Aå.VHYAF¢.z%ÁbÝHx@B.²åEòÝŽ¼Íž?#üÍ¨@è@Ø`Æx@Æ\r`@‘Åc†<6'”W@ÒÇšXctË\0\r ê§©L|Èv\n ¨ÀZ\0@SÈH¦¾7ObsÈ’Ù­ÐóÇà#‹Ìv­dHNÐ*À›'RxY¡.ÐæÎ€9ƒC–èDvÐ`Í‘`¼¡@\"–Š?¬â­æ\rêì\r¥43C\\6ÒúReì)a¿Âæp¡<kÎ¤ç¡Î,®Ìø!Ð¡¹“&%Œ ìN\"!Ñ\"pzà¡&(E•+ïd‚fÈÔ£.3*ðª\ràà”*ÈÃu3p\nGQË¼Æ`fBZÊÎúõÁ2ôËSˆõ…2.FÂ,Ø±\nÉ< ê\r²î\0g:Ïr,Ä[­ŒN®Ö¡|.xObÊ<Ó,¹’L?‚kÙ=+¦<Ó=4e!%0,ÁêØFdjFà	\0@š	 t\n`¦";break;}$li=array();foreach(explode("\n",lzw_decompress($f))as$X)$li[]=(strpos($X,"\t")?explode("\t",$X):$X);return$li;}if(!$li){$li=get_translations($ca);$_SESSION["translations"]=$li;}if(extension_loaded('pdo')){class
Min_PDO
extends
PDO{var$_result,$server_info,$affected_rows,$errno,$error;function
__construct(){global$b;$Xf=array_search("SQL",$b->operators);if($Xf!==false)unset($b->operators[$Xf]);}function
dsn($jc,$V,$F,$sf=array()){try{parent::__construct($jc,$V,$F,$sf);}catch(Exception$Ac){auth_error(h($Ac->getMessage()));}$this->setAttribute(13,array('Min_PDOStatement'));$this->server_info=@$this->getAttribute(4);}function
query($G,$vi=false){$H=parent::query($G);$this->error="";if(!$H){list(,$this->errno,$this->error)=$this->errorInfo();return
false;}$this->store_result($H);return$H;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result($H=null){if(!$H){$H=$this->_result;if(!$H)return
false;}if($H->columnCount()){$H->num_rows=$H->rowCount();return$H;}$this->affected_rows=$H->rowCount();return
true;}function
next_result(){if(!$this->_result)return
false;$this->_result->_offset=0;return@$this->_result->nextRowset();}function
result($G,$p=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch();return$J[$p];}}class
Min_PDOStatement
extends
PDOStatement{var$_offset=0,$num_rows;function
fetch_assoc(){return$this->fetch(2);}function
fetch_row(){return$this->fetch(3);}function
fetch_field(){$J=(object)$this->getColumnMeta($this->_offset++);$J->orgtable=$J->table;$J->orgname=$J->name;$J->charsetnr=(in_array("blob",(array)$J->flags)?63:0);return$J;}}}$ec=array();class
Min_SQL{var$_conn;function
__construct($g){$this->_conn=$g;}function
select($R,$L,$Z,$md,$uf=array(),$_=1,$E=0,$fg=false){global$b,$y;$Td=(count($md)<count($L));$G=$b->selectQueryBuild($L,$Z,$md,$uf,$_,$E);if(!$G)$G="SELECT".limit(($_GET["page"]!="last"&&$_!=""&&$md&&$Td&&$y=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$L)."\nFROM ".table($R),($Z?"\nWHERE ".implode(" AND ",$Z):"").($md&&$Td?"\nGROUP BY ".implode(", ",$md):"").($uf?"\nORDER BY ".implode(", ",$uf):""),($_!=""?+$_:null),($E?$_*$E:0),"\n");$vh=microtime(true);$I=$this->_conn->query($G);if($fg)echo$b->selectQuery($G,$vh,!$I);return$I;}function
delete($R,$pg,$_=0){$G="FROM ".table($R);return
queries("DELETE".($_?limit1($R,$G,$pg):" $G$pg"));}function
update($R,$O,$pg,$_=0,$M="\n"){$Mi=array();foreach($O
as$z=>$X)$Mi[]="$z = $X";$G=table($R)." SET$M".implode(",$M",$Mi);return
queries("UPDATE".($_?limit1($R,$G,$pg,$M):" $G$pg"));}function
insert($R,$O){return
queries("INSERT INTO ".table($R).($O?" (".implode(", ",array_keys($O)).")\nVALUES (".implode(", ",$O).")":" DEFAULT VALUES"));}function
insertUpdate($R,$K,$dg){return
false;}function
begin(){return
queries("BEGIN");}function
commit(){return
queries("COMMIT");}function
rollback(){return
queries("ROLLBACK");}function
convertSearch($v,$X,$p){return$v;}function
value($X,$p){return$X;}function
quoteBinary($Rg){return
q($Rg);}function
warnings(){return'';}function
tableHelp($C){}}$ec["sqlite"]="SQLite 3";$ec["sqlite2"]="SQLite 2";if(isset($_GET["sqlite"])||isset($_GET["sqlite2"])){$ag=array((isset($_GET["sqlite"])?"SQLite3":"SQLite"),"PDO_SQLite");define("DRIVER",(isset($_GET["sqlite"])?"sqlite":"sqlite2"));if(class_exists(isset($_GET["sqlite"])?"SQLite3":"SQLiteDatabase")){if(isset($_GET["sqlite"])){class
Min_SQLite{var$extension="SQLite3",$server_info,$affected_rows,$errno,$error,$_link;function
__construct($Uc){$this->_link=new
SQLite3($Uc);$Pi=$this->_link->version();$this->server_info=$Pi["versionString"];}function
query($G){$H=@$this->_link->query($G);$this->error="";if(!$H){$this->errno=$this->_link->lastErrorCode();$this->error=$this->_link->lastErrorMsg();return
false;}elseif($H->numColumns())return
new
Min_Result($H);$this->affected_rows=$this->_link->changes();return
true;}function
quote($Q){return(is_utf8($Q)?"'".$this->_link->escapeString($Q)."'":"x'".reset(unpack('H*',$Q))."'");}function
store_result(){return$this->_result;}function
result($G,$p=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->_result->fetchArray();return$J[$p];}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;}function
fetch_assoc(){return$this->_result->fetchArray(SQLITE3_ASSOC);}function
fetch_row(){return$this->_result->fetchArray(SQLITE3_NUM);}function
fetch_field(){$d=$this->_offset++;$U=$this->_result->columnType($d);return(object)array("name"=>$this->_result->columnName($d),"type"=>$U,"charsetnr"=>($U==SQLITE3_BLOB?63:0),);}function
__desctruct(){return$this->_result->finalize();}}}else{class
Min_SQLite{var$extension="SQLite",$server_info,$affected_rows,$error,$_link;function
__construct($Uc){$this->server_info=sqlite_libversion();$this->_link=new
SQLiteDatabase($Uc);}function
query($G,$vi=false){$Ne=($vi?"unbufferedQuery":"query");$H=@$this->_link->$Ne($G,SQLITE_BOTH,$o);$this->error="";if(!$H){$this->error=$o;return
false;}elseif($H===true){$this->affected_rows=$this->changes();return
true;}return
new
Min_Result($H);}function
quote($Q){return"'".sqlite_escape_string($Q)."'";}function
store_result(){return$this->_result;}function
result($G,$p=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->_result->fetch();return$J[$p];}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;if(method_exists($H,'numRows'))$this->num_rows=$H->numRows();}function
fetch_assoc(){$J=$this->_result->fetch(SQLITE_ASSOC);if(!$J)return
false;$I=array();foreach($J
as$z=>$X)$I[($z[0]=='"'?idf_unescape($z):$z)]=$X;return$I;}function
fetch_row(){return$this->_result->fetch(SQLITE_NUM);}function
fetch_field(){$C=$this->_result->fieldName($this->_offset++);$Tf='(\\[.*]|"(?:[^"]|"")*"|(.+))';if(preg_match("~^($Tf\\.)?$Tf\$~",$C,$B)){$R=($B[3]!=""?$B[3]:idf_unescape($B[2]));$C=($B[5]!=""?$B[5]:idf_unescape($B[4]));}return(object)array("name"=>$C,"orgname"=>$C,"orgtable"=>$R,);}}}}elseif(extension_loaded("pdo_sqlite")){class
Min_SQLite
extends
Min_PDO{var$extension="PDO_SQLite";function
__construct($Uc){$this->dsn(DRIVER.":$Uc","","");}}}if(class_exists("Min_SQLite")){class
Min_DB
extends
Min_SQLite{function
__construct(){parent::__construct(":memory:");$this->query("PRAGMA foreign_keys = 1");}function
select_db($Uc){if(is_readable($Uc)&&$this->query("ATTACH ".$this->quote(preg_match("~(^[/\\\\]|:)~",$Uc)?$Uc:dirname($_SERVER["SCRIPT_FILENAME"])."/$Uc")." AS a")){parent::__construct($Uc);$this->query("PRAGMA foreign_keys = 1");return
true;}return
false;}function
multi_query($G){return$this->_result=$this->query($G);}function
next_result(){return
false;}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($R,$K,$dg){$Mi=array();foreach($K
as$O)$Mi[]="(".implode(", ",$O).")";return
queries("REPLACE INTO ".table($R)." (".implode(", ",array_keys(reset($K))).") VALUES\n".implode(",\n",$Mi));}function
tableHelp($C){if($C=="sqlite_sequence")return"fileformat2.html#seqtab";if($C=="sqlite_master")return"fileformat2.html#$C";}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect(){return
new
Min_DB;}function
get_databases(){return
array();}function
limit($G,$Z,$_,$D=0,$M=" "){return" $G$Z".($_!==null?$M."LIMIT $_".($D?" OFFSET $D":""):"");}function
limit1($R,$G,$Z,$M="\n"){global$g;return(preg_match('~^INTO~',$G)||$g->result("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")?limit($G,$Z,1,0,$M):" $G WHERE rowid = (SELECT rowid FROM ".table($R).$Z.$M."LIMIT 1)");}function
db_collation($m,$qb){global$g;return$g->result("PRAGMA encoding");}function
engines(){return
array();}function
logged_user(){return
get_current_user();}function
tables_list(){return
get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name",1);}function
count_tables($l){return
array();}function
table_status($C=""){global$g;$I=array();foreach(get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') ".($C!=""?"AND name = ".q($C):"ORDER BY name"))as$J){$J["Rows"]=$g->result("SELECT COUNT(*) FROM ".idf_escape($J["Name"]));$I[$J["Name"]]=$J;}foreach(get_rows("SELECT * FROM sqlite_sequence",null,"")as$J)$I[$J["name"]]["Auto_increment"]=$J["seq"];return($C!=""?$I[$C]:$I);}function
is_view($S){return$S["Engine"]=="view";}function
fk_support($S){global$g;return!$g->result("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");}function
fields($R){global$g;$I=array();$dg="";foreach(get_rows("PRAGMA table_info(".table($R).")")as$J){$C=$J["name"];$U=strtolower($J["type"]);$Sb=$J["dflt_value"];$I[$C]=array("field"=>$C,"type"=>(preg_match('~int~i',$U)?"integer":(preg_match('~char|clob|text~i',$U)?"text":(preg_match('~blob~i',$U)?"blob":(preg_match('~real|floa|doub~i',$U)?"real":"numeric")))),"full_type"=>$U,"default"=>(preg_match("~'(.*)'~",$Sb,$B)?str_replace("''","'",$B[1]):($Sb=="NULL"?null:$Sb)),"null"=>!$J["notnull"],"privileges"=>array("select"=>1,"insert"=>1,"update"=>1),"primary"=>$J["pk"],);if($J["pk"]){if($dg!="")$I[$dg]["auto_increment"]=false;elseif(preg_match('~^integer$~i',$U))$I[$C]["auto_increment"]=true;$dg=$C;}}$qh=$g->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($R));preg_match_all('~(("[^"]*+")+|[a-z0-9_]+)\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i',$qh,$_e,PREG_SET_ORDER);foreach($_e
as$B){$C=str_replace('""','"',preg_replace('~^"|"$~','',$B[1]));if($I[$C])$I[$C]["collation"]=trim($B[3],"'");}return$I;}function
indexes($R,$h=null){global$g;if(!is_object($h))$h=$g;$I=array();$qh=$h->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($R));if(preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i',$qh,$B)){$I[""]=array("type"=>"PRIMARY","columns"=>array(),"lengths"=>array(),"descs"=>array());preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i',$B[1],$_e,PREG_SET_ORDER);foreach($_e
as$B){$I[""]["columns"][]=idf_unescape($B[2]).$B[4];$I[""]["descs"][]=(preg_match('~DESC~i',$B[5])?'1':null);}}if(!$I){foreach(fields($R)as$C=>$p){if($p["primary"])$I[""]=array("type"=>"PRIMARY","columns"=>array($C),"lengths"=>array(),"descs"=>array(null));}}$th=get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = ".q($R),$h);foreach(get_rows("PRAGMA index_list(".table($R).")",$h)as$J){$C=$J["name"];$w=array("type"=>($J["unique"]?"UNIQUE":"INDEX"));$w["lengths"]=array();$w["descs"]=array();foreach(get_rows("PRAGMA index_info(".idf_escape($C).")",$h)as$Qg){$w["columns"][]=$Qg["name"];$w["descs"][]=null;}if(preg_match('~^CREATE( UNIQUE)? INDEX '.preg_quote(idf_escape($C).' ON '.idf_escape($R),'~').' \((.*)\)$~i',$th[$C],$Ag)){preg_match_all('/("[^"]*+")+( DESC)?/',$Ag[2],$_e);foreach($_e[2]as$z=>$X){if($X)$w["descs"][$z]='1';}}if(!$I[""]||$w["type"]!="UNIQUE"||$w["columns"]!=$I[""]["columns"]||$w["descs"]!=$I[""]["descs"]||!preg_match("~^sqlite_~",$C))$I[$C]=$w;}return$I;}function
foreign_keys($R){$I=array();foreach(get_rows("PRAGMA foreign_key_list(".table($R).")")as$J){$r=&$I[$J["id"]];if(!$r)$r=$J;$r["source"][]=$J["from"];$r["target"][]=$J["to"];}return$I;}function
view($C){global$g;return
array("select"=>preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\\s+~iU','',$g->result("SELECT sql FROM sqlite_master WHERE name = ".q($C))));}function
collations(){return(isset($_GET["create"])?get_vals("PRAGMA collation_list",1):array());}function
information_schema($m){return
false;}function
error(){global$g;return
h($g->error);}function
check_sqlite_name($C){global$g;$Kc="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($Kc)\$~",$C)){$g->error=lang(21,str_replace("|",", ",$Kc));return
false;}return
true;}function
create_database($m,$pb){global$g;if(file_exists($m)){$g->error=lang(22);return
false;}if(!check_sqlite_name($m))return
false;try{$A=new
Min_SQLite($m);}catch(Exception$Ac){$g->error=$Ac->getMessage();return
false;}$A->query('PRAGMA encoding = "UTF-8"');$A->query('CREATE TABLE adminer (i)');$A->query('DROP TABLE adminer');return
true;}function
drop_databases($l){global$g;$g->__construct(":memory:");foreach($l
as$m){if(!@unlink($m)){$g->error=lang(22);return
false;}}return
true;}function
rename_database($C,$pb){global$g;if(!check_sqlite_name($C))return
false;$g->__construct(":memory:");$g->error=lang(22);return@rename(DB,$C);}function
auto_increment(){return" PRIMARY KEY".(DRIVER=="sqlite"?" AUTOINCREMENT":"");}function
alter_table($R,$C,$q,$bd,$vb,$uc,$pb,$Ma,$Nf){$Gi=($R==""||$bd);foreach($q
as$p){if($p[0]!=""||!$p[1]||$p[2]){$Gi=true;break;}}$c=array();$Cf=array();foreach($q
as$p){if($p[1]){$c[]=($Gi?$p[1]:"ADD ".implode($p[1]));if($p[0]!="")$Cf[$p[0]]=$p[1][0];}}if(!$Gi){foreach($c
as$X){if(!queries("ALTER TABLE ".table($R)." $X"))return
false;}if($R!=$C&&!queries("ALTER TABLE ".table($R)." RENAME TO ".table($C)))return
false;}elseif(!recreate_table($R,$C,$c,$Cf,$bd))return
false;if($Ma)queries("UPDATE sqlite_sequence SET seq = $Ma WHERE name = ".q($C));return
true;}function
recreate_table($R,$C,$q,$Cf,$bd,$x=array()){if($R!=""){if(!$q){foreach(fields($R)as$z=>$p){if($x)$p["auto_increment"]=0;$q[]=process_field($p,$p);$Cf[$z]=idf_escape($z);}}$eg=false;foreach($q
as$p){if($p[6])$eg=true;}$hc=array();foreach($x
as$z=>$X){if($X[2]=="DROP"){$hc[$X[1]]=true;unset($x[$z]);}}foreach(indexes($R)as$be=>$w){$e=array();foreach($w["columns"]as$z=>$d){if(!$Cf[$d])continue
2;$e[]=$Cf[$d].($w["descs"][$z]?" DESC":"");}if(!$hc[$be]){if($w["type"]!="PRIMARY"||!$eg)$x[]=array($w["type"],$be,$e);}}foreach($x
as$z=>$X){if($X[0]=="PRIMARY"){unset($x[$z]);$bd[]="  PRIMARY KEY (".implode(", ",$X[2]).")";}}foreach(foreign_keys($R)as$be=>$r){foreach($r["source"]as$z=>$d){if(!$Cf[$d])continue
2;$r["source"][$z]=idf_unescape($Cf[$d]);}if(!isset($bd[" $be"]))$bd[]=" ".format_foreign_key($r);}queries("BEGIN");}foreach($q
as$z=>$p)$q[$z]="  ".implode($p);$q=array_merge($q,array_filter($bd));if(!queries("CREATE TABLE ".table($R!=""?"adminer_$C":$C)." (\n".implode(",\n",$q)."\n)"))return
false;if($R!=""){if($Cf&&!queries("INSERT INTO ".table("adminer_$C")." (".implode(", ",$Cf).") SELECT ".implode(", ",array_map('idf_escape',array_keys($Cf)))." FROM ".table($R)))return
false;$ri=array();foreach(triggers($R)as$pi=>$Xh){$oi=trigger($pi);$ri[]="CREATE TRIGGER ".idf_escape($pi)." ".implode(" ",$Xh)." ON ".table($C)."\n$oi[Statement]";}if(!queries("DROP TABLE ".table($R)))return
false;queries("ALTER TABLE ".table("adminer_$C")." RENAME TO ".table($C));if(!alter_indexes($C,$x))return
false;foreach($ri
as$oi){if(!queries($oi))return
false;}queries("COMMIT");}return
true;}function
index_sql($R,$U,$C,$e){return"CREATE $U ".($U!="INDEX"?"INDEX ":"").idf_escape($C!=""?$C:uniqid($R."_"))." ON ".table($R)." $e";}function
alter_indexes($R,$c){foreach($c
as$dg){if($dg[0]=="PRIMARY")return
recreate_table($R,$R,array(),array(),array(),$c);}foreach(array_reverse($c)as$X){if(!queries($X[2]=="DROP"?"DROP INDEX ".idf_escape($X[1]):index_sql($R,$X[0],$X[1],"(".implode(", ",$X[2]).")")))return
false;}return
true;}function
truncate_tables($T){return
apply_queries("DELETE FROM",$T);}function
drop_views($Ri){return
apply_queries("DROP VIEW",$Ri);}function
drop_tables($T){return
apply_queries("DROP TABLE",$T);}function
move_tables($T,$Ri,$Oh){return
false;}function
trigger($C){global$g;if($C=="")return
array("Statement"=>"BEGIN\n\t;\nEND");$v='(?:[^`"\\s]+|`[^`]*`|"[^"]*")+';$qi=trigger_options();preg_match("~^CREATE\\s+TRIGGER\\s*$v\\s*(".implode("|",$qi["Timing"]).")\\s+([a-z]+)(?:\\s+OF\\s+($v))?\\s+ON\\s*$v\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",$g->result("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = ".q($C)),$B);$df=$B[3];return
array("Timing"=>strtoupper($B[1]),"Event"=>strtoupper($B[2]).($df?" OF":""),"Of"=>($df[0]=='`'||$df[0]=='"'?idf_unescape($df):$df),"Trigger"=>$C,"Statement"=>$B[4],);}function
triggers($R){$I=array();$qi=trigger_options();foreach(get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($R))as$J){preg_match('~^CREATE\\s+TRIGGER\\s*(?:[^`"\\s]+|`[^`]*`|"[^"]*")+\\s*('.implode("|",$qi["Timing"]).')\\s*(.*)\\s+ON\\b~iU',$J["sql"],$B);$I[$J["name"]]=array($B[1],$B[2]);}return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
begin(){return
queries("BEGIN");}function
last_id(){global$g;return$g->result("SELECT LAST_INSERT_ROWID()");}function
explain($g,$G){return$g->query("EXPLAIN QUERY PLAN $G");}function
found_rows($S,$Z){}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Ug){return
true;}function
create_sql($R,$Ma,$_h){global$g;$I=$g->result("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = ".q($R));foreach(indexes($R)as$C=>$w){if($C=='')continue;$I.=";\n\n".index_sql($R,$w['type'],$C,"(".implode(", ",array_map('idf_escape',$w['columns'])).")");}return$I;}function
truncate_sql($R){return"DELETE FROM ".table($R);}function
use_sql($k){}function
trigger_sql($R){return
implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($R)));}function
show_variables(){global$g;$I=array();foreach(array("auto_vacuum","cache_size","count_changes","default_cache_size","empty_result_callbacks","encoding","foreign_keys","full_column_names","fullfsync","journal_mode","journal_size_limit","legacy_file_format","locking_mode","page_size","max_page_count","read_uncommitted","recursive_triggers","reverse_unordered_selects","secure_delete","short_column_names","synchronous","temp_store","temp_store_directory","schema_version","integrity_check","quick_check")as$z)$I[$z]=$g->result("PRAGMA $z");return$I;}function
show_status(){$I=array();foreach(get_vals("PRAGMA compile_options")as$rf){list($z,$X)=explode("=",$rf,2);$I[$z]=$X;}return$I;}function
convert_field($p){}function
unconvert_field($p,$I){return$I;}function
support($Pc){return
preg_match('~^(columns|database|drop_col|dump|indexes|move_col|sql|status|table|trigger|variables|view|view_trigger)$~',$Pc);}$y="sqlite";$ui=array("integer"=>0,"real"=>0,"numeric"=>0,"text"=>0,"blob"=>0);$zh=array_keys($ui);$Ai=array();$pf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");$jd=array("hex","length","lower","round","unixepoch","upper");$pd=array("avg","count","count distinct","group_concat","max","min","sum");$mc=array(array(),array("integer|real|numeric"=>"+/-","text"=>"||",));}$ec["pgsql"]="PostgreSQL";if(isset($_GET["pgsql"])){$ag=array("PgSQL","PDO_PgSQL");define("DRIVER","pgsql");if(extension_loaded("pgsql")){class
Min_DB{var$extension="PgSQL",$_link,$_result,$_string,$_database=true,$server_info,$affected_rows,$error;function
_error($xc,$o){if(ini_bool("html_errors"))$o=html_entity_decode(strip_tags($o));$o=preg_replace('~^[^:]*: ~','',$o);$this->error=$o;}function
connect($N,$V,$F){global$b;$m=$b->database();set_error_handler(array($this,'_error'));$this->_string="host='".str_replace(":","' port='",addcslashes($N,"'\\"))."' user='".addcslashes($V,"'\\")."' password='".addcslashes($F,"'\\")."'";$this->_link=@pg_connect("$this->_string dbname='".($m!=""?addcslashes($m,"'\\"):"postgres")."'",PGSQL_CONNECT_FORCE_NEW);if(!$this->_link&&$m!=""){$this->_database=false;$this->_link=@pg_connect("$this->_string dbname='postgres'",PGSQL_CONNECT_FORCE_NEW);}restore_error_handler();if($this->_link){$Pi=pg_version($this->_link);$this->server_info=$Pi["server"];pg_set_client_encoding($this->_link,"UTF8");}return(bool)$this->_link;}function
quote($Q){return"'".pg_escape_string($this->_link,$Q)."'";}function
value($X,$p){return($p["type"]=="bytea"?pg_unescape_bytea($X):$X);}function
quoteBinary($Q){return"'".pg_escape_bytea($this->_link,$Q)."'";}function
select_db($k){global$b;if($k==$b->database())return$this->_database;$I=@pg_connect("$this->_string dbname='".addcslashes($k,"'\\")."'",PGSQL_CONNECT_FORCE_NEW);if($I)$this->_link=$I;return$I;}function
close(){$this->_link=@pg_connect("$this->_string dbname='postgres'");}function
query($G,$vi=false){$H=@pg_query($this->_link,$G);$this->error="";if(!$H){$this->error=pg_last_error($this->_link);return
false;}elseif(!pg_num_fields($H)){$this->affected_rows=pg_affected_rows($H);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$p=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;return
pg_fetch_result($H->_result,0,$p);}function
warnings(){return
h(pg_last_notice($this->_link));}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;$this->num_rows=pg_num_rows($H);}function
fetch_assoc(){return
pg_fetch_assoc($this->_result);}function
fetch_row(){return
pg_fetch_row($this->_result);}function
fetch_field(){$d=$this->_offset++;$I=new
stdClass;if(function_exists('pg_field_table'))$I->orgtable=pg_field_table($this->_result,$d);$I->name=pg_field_name($this->_result,$d);$I->orgname=$I->name;$I->type=pg_field_type($this->_result,$d);$I->charsetnr=($I->type=="bytea"?63:0);return$I;}function
__destruct(){pg_free_result($this->_result);}}}elseif(extension_loaded("pdo_pgsql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_PgSQL";function
connect($N,$V,$F){global$b;$m=$b->database();$Q="pgsql:host='".str_replace(":","' port='",addcslashes($N,"'\\"))."' options='-c client_encoding=utf8'";$this->dsn("$Q dbname='".($m!=""?addcslashes($m,"'\\"):"postgres")."'",$V,$F);return
true;}function
select_db($k){global$b;return($b->database()==$k);}function
value($X,$p){return$X;}function
quoteBinary($Rg){return
q($Rg);}function
warnings(){return'';}function
close(){}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($R,$K,$dg){global$g;foreach($K
as$O){$Bi=array();$Z=array();foreach($O
as$z=>$X){$Bi[]="$z = $X";if(isset($dg[idf_unescape($z)]))$Z[]="$z = $X";}if(!(($Z&&queries("UPDATE ".table($R)." SET ".implode(", ",$Bi)." WHERE ".implode(" AND ",$Z))&&$g->affected_rows)||queries("INSERT INTO ".table($R)." (".implode(", ",array_keys($O)).") VALUES (".implode(", ",$O).")")))return
false;}return
true;}function
convertSearch($v,$X,$p){return(preg_match('~char|text'.(is_numeric($X["val"])&&!preg_match('~LIKE~',$X["op"])?'|'.number_type():'').'~',$p["type"])?$v:"CAST($v AS text)");}function
value($X,$p){return$this->_conn->value($X,$p);}function
quoteBinary($Rg){return$this->_conn->quoteBinary($Rg);}function
warnings(){return$this->_conn->warnings();}function
tableHelp($C){$se=array("information_schema"=>"infoschema","pg_catalog"=>"catalog",);$A=$se[$_GET["ns"]];if($A)return"$A-".str_replace("_","-",$C).".html";}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect(){global$b,$ui,$zh;$g=new
Min_DB;$j=$b->credentials();if($g->connect($j[0],$j[1],$j[2])){if(min_version(9,0,$g)){$g->query("SET application_name = 'Adminer'");if(min_version(9.2,0,$g)){$zh[lang(23)][]="json";$ui["json"]=4294967295;if(min_version(9.4,0,$g)){$zh[lang(23)][]="jsonb";$ui["jsonb"]=4294967295;}}}return$g;}return$g->error;}function
get_databases(){return
get_vals("SELECT datname FROM pg_database WHERE has_database_privilege(datname, 'CONNECT') ORDER BY datname");}function
limit($G,$Z,$_,$D=0,$M=" "){return" $G$Z".($_!==null?$M."LIMIT $_".($D?" OFFSET $D":""):"");}function
limit1($R,$G,$Z,$M="\n"){return(preg_match('~^INTO~',$G)?limit($G,$Z,1,0,$M):" $G WHERE ctid = (SELECT ctid FROM ".table($R).$Z.$M."LIMIT 1)");}function
db_collation($m,$qb){global$g;return$g->result("SHOW LC_COLLATE");}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT user");}function
tables_list(){$G="SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";if(support('materializedview'))$G.="
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";$G.="
ORDER BY 1";return
get_key_vals($G);}function
count_tables($l){return
array();}function
table_status($C=""){$I=array();foreach(get_rows("SELECT c.relname AS \"Name\", CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\", pg_relation_size(c.oid) AS \"Data_length\", pg_total_relation_size(c.oid) - pg_relation_size(c.oid) AS \"Index_length\", obj_description(c.oid, 'pg_class') AS \"Comment\", CASE WHEN c.relhasoids THEN 'oid' ELSE '' END AS \"Oid\", c.reltuples as \"Rows\", n.nspname
FROM pg_class c
JOIN pg_namespace n ON(n.nspname = current_schema() AND n.oid = c.relnamespace)
WHERE relkind IN ('r', 'm', 'v', 'f')
".($C!=""?"AND relname = ".q($C):"ORDER BY relname"))as$J)$I[$J["Name"]]=$J;return($C!=""?$I[$C]:$I);}function
is_view($S){return
in_array($S["Engine"],array("view","materialized view"));}function
fk_support($S){return
true;}function
fields($R){$I=array();$Da=array('timestamp without time zone'=>'timestamp','timestamp with time zone'=>'timestamptz',);foreach(get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, d.adsrc AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = ".q($R)."
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum")as$J){preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~',$J["full_type"],$B);list(,$U,$pe,$J["length"],$xa,$Ga)=$B;$J["length"].=$Ga;$eb=$U.$xa;if(isset($Da[$eb])){$J["type"]=$Da[$eb];$J["full_type"]=$J["type"].$pe.$Ga;}else{$J["type"]=$U;$J["full_type"]=$J["type"].$pe.$xa.$Ga;}$J["null"]=!$J["attnotnull"];$J["auto_increment"]=preg_match('~^nextval\\(~i',$J["default"]);$J["privileges"]=array("insert"=>1,"select"=>1,"update"=>1);if(preg_match('~(.+)::[^)]+(.*)~',$J["default"],$B))$J["default"]=($B[1]=="NULL"?null:(($B[1][0]=="'"?idf_unescape($B[1]):$B[1]).$B[2]));$I[$J["field"]]=$J;}return$I;}function
indexes($R,$h=null){global$g;if(!is_object($h))$h=$g;$I=array();$Hh=$h->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($R));$e=get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Hh AND attnum > 0",$h);foreach(get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption , (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $Hh AND ci.oid = i.indexrelid",$h)as$J){$Bg=$J["relname"];$I[$Bg]["type"]=($J["indispartial"]?"INDEX":($J["indisprimary"]?"PRIMARY":($J["indisunique"]?"UNIQUE":"INDEX")));$I[$Bg]["columns"]=array();foreach(explode(" ",$J["indkey"])as$Id)$I[$Bg]["columns"][]=$e[$Id];$I[$Bg]["descs"]=array();foreach(explode(" ",$J["indoption"])as$Jd)$I[$Bg]["descs"][]=($Jd&1?'1':null);$I[$Bg]["lengths"]=array();}return$I;}function
foreign_keys($R){global$kf;$I=array();foreach(get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = ".q($R)." AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname")as$J){if(preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA',$J['definition'],$B)){$J['source']=array_map('trim',explode(',',$B[1]));if(preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~',$B[2],$ze)){$J['ns']=str_replace('""','"',preg_replace('~^"(.+)"$~','\1',$ze[2]));$J['table']=str_replace('""','"',preg_replace('~^"(.+)"$~','\1',$ze[4]));}$J['target']=array_map('trim',explode(',',$B[3]));$J['on_delete']=(preg_match("~ON DELETE ($kf)~",$B[4],$ze)?$ze[1]:'NO ACTION');$J['on_update']=(preg_match("~ON UPDATE ($kf)~",$B[4],$ze)?$ze[1]:'NO ACTION');$I[$J['conname']]=$J;}}return$I;}function
view($C){global$g;return
array("select"=>trim($g->result("SELECT view_definition
FROM information_schema.views
WHERE table_schema = current_schema() AND table_name = ".q($C))));}function
collations(){return
array();}function
information_schema($m){return($m=="information_schema");}function
error(){global$g;$I=h($g->error);if(preg_match('~^(.*\\n)?([^\\n]*)\\n( *)\\^(\\n.*)?$~s',$I,$B))$I=$B[1].preg_replace('~((?:[^&]|&[^;]*;){'.strlen($B[3]).'})(.*)~','\\1<b>\\2</b>',$B[2]).$B[4];return
nl_br($I);}function
create_database($m,$pb){return
queries("CREATE DATABASE ".idf_escape($m).($pb?" ENCODING ".idf_escape($pb):""));}function
drop_databases($l){global$g;$g->close();return
apply_queries("DROP DATABASE",$l,'idf_escape');}function
rename_database($C,$pb){return
queries("ALTER DATABASE ".idf_escape(DB)." RENAME TO ".idf_escape($C));}function
auto_increment(){return"";}function
alter_table($R,$C,$q,$bd,$vb,$uc,$pb,$Ma,$Nf){$c=array();$og=array();foreach($q
as$p){$d=idf_escape($p[0]);$X=$p[1];if(!$X)$c[]="DROP $d";else{$Li=$X[5];unset($X[5]);if(isset($X[6])&&$p[0]=="")$X[1]=($X[1]=="bigint"?" big":" ")."serial";if($p[0]=="")$c[]=($R!=""?"ADD ":"  ").implode($X);else{if($d!=$X[0])$og[]="ALTER TABLE ".table($R)." RENAME $d TO $X[0]";$c[]="ALTER $d TYPE$X[1]";if(!$X[6]){$c[]="ALTER $d ".($X[3]?"SET$X[3]":"DROP DEFAULT");$c[]="ALTER $d ".($X[2]==" NULL"?"DROP NOT":"SET").$X[2];}}if($p[0]!=""||$Li!="")$og[]="COMMENT ON COLUMN ".table($R).".$X[0] IS ".($Li!=""?substr($Li,9):"''");}}$c=array_merge($c,$bd);if($R=="")array_unshift($og,"CREATE TABLE ".table($C)." (\n".implode(",\n",$c)."\n)");elseif($c)array_unshift($og,"ALTER TABLE ".table($R)."\n".implode(",\n",$c));if($R!=""&&$R!=$C)$og[]="ALTER TABLE ".table($R)." RENAME TO ".table($C);if($R!=""||$vb!="")$og[]="COMMENT ON TABLE ".table($C)." IS ".q($vb);if($Ma!=""){}foreach($og
as$G){if(!queries($G))return
false;}return
true;}function
alter_indexes($R,$c){$i=array();$fc=array();$og=array();foreach($c
as$X){if($X[0]!="INDEX")$i[]=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");elseif($X[2]=="DROP")$fc[]=idf_escape($X[1]);else$og[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($R."_"))." ON ".table($R)." (".implode(", ",$X[2]).")";}if($i)array_unshift($og,"ALTER TABLE ".table($R).implode(",",$i));if($fc)array_unshift($og,"DROP INDEX ".implode(", ",$fc));foreach($og
as$G){if(!queries($G))return
false;}return
true;}function
truncate_tables($T){return
queries("TRUNCATE ".implode(", ",array_map('table',$T)));return
true;}function
drop_views($Ri){return
drop_tables($Ri);}function
drop_tables($T){foreach($T
as$R){$P=table_status($R);if(!queries("DROP ".strtoupper($P["Engine"])." ".table($R)))return
false;}return
true;}function
move_tables($T,$Ri,$Oh){foreach(array_merge($T,$Ri)as$R){$P=table_status($R);if(!queries("ALTER ".strtoupper($P["Engine"])." ".table($R)." SET SCHEMA ".idf_escape($Oh)))return
false;}return
true;}function
trigger($C,$R=null){if($C=="")return
array("Statement"=>"EXECUTE PROCEDURE ()");if($R===null)$R=$_GET['trigger'];$K=get_rows('SELECT t.trigger_name AS "Trigger", t.action_timing AS "Timing", (SELECT STRING_AGG(event_manipulation, \' OR \') FROM information_schema.triggers WHERE event_object_table = t.event_object_table AND trigger_name = t.trigger_name ) AS "Events", t.event_manipulation AS "Event", \'FOR EACH \' || t.action_orientation AS "Type", t.action_statement AS "Statement" FROM information_schema.triggers t WHERE t.event_object_table = '.q($R).' AND t.trigger_name = '.q($C));return
reset($K);}function
triggers($R){$I=array();foreach(get_rows("SELECT * FROM information_schema.triggers WHERE event_object_table = ".q($R))as$J)$I[$J["trigger_name"]]=array($J["action_timing"],$J["event_manipulation"]);return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW","FOR EACH STATEMENT"),);}function
routine($C,$U){$K=get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = '.q($C));$I=$K[0];$I["returns"]=array("type"=>$I["type_udt_name"]);$I["fields"]=get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = '.q($C).'
ORDER BY ordinal_position');return$I;}function
routines(){return
get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');}function
routine_languages(){return
get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");}function
routine_id($C,$J){$I=array();foreach($J["fields"]as$p)$I[]=$p["type"];return
idf_escape($C)."(".implode(", ",$I).")";}function
last_id(){return
0;}function
explain($g,$G){return$g->query("EXPLAIN $G");}function
found_rows($S,$Z){global$g;if(preg_match("~ rows=([0-9]+)~",$g->result("EXPLAIN SELECT * FROM ".idf_escape($S["Name"]).($Z?" WHERE ".implode(" AND ",$Z):"")),$Ag))return$Ag[1];return
false;}function
types(){return
get_vals("SELECT typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");}function
schemas(){return
get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");}function
get_schema(){global$g;return$g->result("SELECT current_schema()");}function
set_schema($Tg){global$g,$ui,$zh;$I=$g->query("SET search_path TO ".idf_escape($Tg));foreach(types()as$U){if(!isset($ui[$U])){$ui[$U]=0;$zh[lang(24)][]=$U;}}return$I;}function
create_sql($R,$Ma,$_h){global$g;$I='';$Jg=array();$dh=array();$P=table_status($R);$q=fields($R);$x=indexes($R);ksort($x);$Zc=foreign_keys($R);ksort($Zc);if(!$P||empty($q))return
false;$I="CREATE TABLE ".idf_escape($P['nspname']).".".idf_escape($P['Name'])." (\n    ";foreach($q
as$Rc=>$p){$Kf=idf_escape($p['field']).' '.$p['full_type'].(is_null($p['default'])?"":" DEFAULT $p[default]").($p['attnotnull']?" NOT NULL":"");$Jg[]=$Kf;if(preg_match('~nextval\(\'([^\']+)\'\)~',$p['default'],$_e)){$ch=$_e[1];$ph=reset(get_rows("SELECT * FROM $ch"));$dh[]=($_h=="DROP+CREATE"?"DROP SEQUENCE $ch;\n":"")."CREATE SEQUENCE $ch INCREMENT $ph[increment_by] MINVALUE $ph[min_value] MAXVALUE $ph[max_value] START ".($Ma?$ph['last_value']:1)." CACHE $ph[cache_value];";}}if(!empty($dh))$I=implode("\n\n",$dh)."\n\n$I";foreach($x
as$Dd=>$w){switch($w['type']){case'UNIQUE':$Jg[]="CONSTRAINT ".idf_escape($Dd)." UNIQUE (".implode(', ',array_map('idf_escape',$w['columns'])).")";break;case'PRIMARY':$Jg[]="CONSTRAINT ".idf_escape($Dd)." PRIMARY KEY (".implode(', ',array_map('idf_escape',$w['columns'])).")";break;}}foreach($Zc
as$Yc=>$Xc)$Jg[]="CONSTRAINT ".idf_escape($Yc)." $Xc[definition] ".($Xc['deferrable']?'DEFERRABLE':'NOT DEFERRABLE');$I.=implode(",\n    ",$Jg)."\n) WITH (oids = ".($P['Oid']?'true':'false').");";foreach($x
as$Dd=>$w){if($w['type']=='INDEX')$I.="\n\nCREATE INDEX ".idf_escape($Dd)." ON ".idf_escape($P['nspname']).".".idf_escape($P['Name'])." USING btree (".implode(', ',array_map('idf_escape',$w['columns'])).");";}if($P['Comment'])$I.="\n\nCOMMENT ON TABLE ".idf_escape($P['nspname']).".".idf_escape($P['Name'])." IS ".q($P['Comment']).";";foreach($q
as$Rc=>$p){if($p['comment'])$I.="\n\nCOMMENT ON COLUMN ".idf_escape($P['nspname']).".".idf_escape($P['Name']).".".idf_escape($Rc)." IS ".q($p['comment']).";";}return
rtrim($I,';');}function
truncate_sql($R){return"TRUNCATE ".table($R);}function
trigger_sql($R){$P=table_status($R);$I="";foreach(triggers($R)as$ni=>$mi){$oi=trigger($ni,$P['Name']);$I.="\nCREATE TRIGGER ".idf_escape($oi['Trigger'])." $oi[Timing] $oi[Events] ON ".idf_escape($P["nspname"]).".".idf_escape($P['Name'])." $oi[Type] $oi[Statement];;\n";}return$I;}function
use_sql($k){return"\connect ".idf_escape($k);}function
show_variables(){return
get_key_vals("SHOW ALL");}function
process_list(){return
get_rows("SELECT * FROM pg_stat_activity ORDER BY ".(min_version(9.2)?"pid":"procpid"));}function
show_status(){}function
convert_field($p){}function
unconvert_field($p,$I){return$I;}function
support($Pc){return
preg_match('~^(database|table|columns|sql|indexes|comment|view|'.(min_version(9.3)?'materializedview|':'').'scheme|routine|processlist|sequence|trigger|type|variables|drop_col|kill|dump)$~',$Pc);}function
kill_process($X){return
queries("SELECT pg_terminate_backend(".number($X).")");}function
connection_id(){return"SELECT pg_backend_pid()";}function
max_connections(){global$g;return$g->result("SHOW max_connections");}$y="pgsql";$ui=array();$zh=array();foreach(array(lang(25)=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),lang(26)=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),lang(23)=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),lang(27)=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),lang(28)=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"txid_snapshot"=>0),lang(29)=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),)as$z=>$X){$ui+=$X;$zh[$z]=array_keys($X);}$Ai=array();$pf=array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","ILIKE","ILIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");$jd=array("char_length","lower","round","to_hex","to_timestamp","upper");$pd=array("avg","count","count distinct","max","min","sum");$mc=array(array("char"=>"md5","date|time"=>"now",),array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",));}$ec["oracle"]="Oracle";if(isset($_GET["oracle"])){$ag=array("OCI8","PDO_OCI");define("DRIVER","oracle");if(extension_loaded("oci8")){class
Min_DB{var$extension="oci8",$_link,$_result,$server_info,$affected_rows,$errno,$error;function
_error($xc,$o){if(ini_bool("html_errors"))$o=html_entity_decode(strip_tags($o));$o=preg_replace('~^[^:]*: ~','',$o);$this->error=$o;}function
connect($N,$V,$F){$this->_link=@oci_new_connect($V,$F,$N,"AL32UTF8");if($this->_link){$this->server_info=oci_server_version($this->_link);return
true;}$o=oci_error();$this->error=$o["message"];return
false;}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}function
select_db($k){return
true;}function
query($G,$vi=false){$H=oci_parse($this->_link,$G);$this->error="";if(!$H){$o=oci_error($this->_link);$this->errno=$o["code"];$this->error=$o["message"];return
false;}set_error_handler(array($this,'_error'));$I=@oci_execute($H);restore_error_handler();if($I){if(oci_num_fields($H))return
new
Min_Result($H);$this->affected_rows=oci_num_rows($H);}return$I;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$p=1){$H=$this->query($G);if(!is_object($H)||!oci_fetch($H->_result))return
false;return
oci_result($H->_result,$p);}}class
Min_Result{var$_result,$_offset=1,$num_rows;function
__construct($H){$this->_result=$H;}function
_convert($J){foreach((array)$J
as$z=>$X){if(is_a($X,'OCI-Lob'))$J[$z]=$X->load();}return$J;}function
fetch_assoc(){return$this->_convert(oci_fetch_assoc($this->_result));}function
fetch_row(){return$this->_convert(oci_fetch_row($this->_result));}function
fetch_field(){$d=$this->_offset++;$I=new
stdClass;$I->name=oci_field_name($this->_result,$d);$I->orgname=$I->name;$I->type=oci_field_type($this->_result,$d);$I->charsetnr=(preg_match("~raw|blob|bfile~",$I->type)?63:0);return$I;}function
__destruct(){oci_free_statement($this->_result);}}}elseif(extension_loaded("pdo_oci")){class
Min_DB
extends
Min_PDO{var$extension="PDO_OCI";function
connect($N,$V,$F){$this->dsn("oci:dbname=//$N;charset=AL32UTF8",$V,$F);return
true;}function
select_db($k){return
true;}}}class
Min_Driver
extends
Min_SQL{function
begin(){return
true;}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect(){global$b;$g=new
Min_DB;$j=$b->credentials();if($g->connect($j[0],$j[1],$j[2]))return$g;return$g->error;}function
get_databases(){return
get_vals("SELECT tablespace_name FROM user_tablespaces");}function
limit($G,$Z,$_,$D=0,$M=" "){return($D?" * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $G$Z) t WHERE rownum <= ".($_+$D).") WHERE rnum > $D":($_!==null?" * FROM (SELECT $G$Z) WHERE rownum <= ".($_+$D):" $G$Z"));}function
limit1($R,$G,$Z,$M="\n"){return" $G$Z";}function
db_collation($m,$qb){global$g;return$g->result("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT USER FROM DUAL");}function
tables_list(){return
get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = ".q(DB)."
UNION SELECT view_name, 'view' FROM user_views
ORDER BY 1");}function
count_tables($l){return
array();}function
table_status($C=""){$I=array();$Vg=q($C);foreach(get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = '.q(DB).($C!=""?" AND table_name = $Vg":"")."
UNION SELECT view_name, 'view', 0, 0 FROM user_views".($C!=""?" WHERE view_name = $Vg":"")."
ORDER BY 1")as$J){if($C!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($S){return$S["Engine"]=="view";}function
fk_support($S){return
true;}function
fields($R){$I=array();foreach(get_rows("SELECT * FROM all_tab_columns WHERE table_name = ".q($R)." ORDER BY column_id")as$J){$U=$J["DATA_TYPE"];$pe="$J[DATA_PRECISION],$J[DATA_SCALE]";if($pe==",")$pe=$J["DATA_LENGTH"];$I[$J["COLUMN_NAME"]]=array("field"=>$J["COLUMN_NAME"],"full_type"=>$U.($pe?"($pe)":""),"type"=>strtolower($U),"length"=>$pe,"default"=>$J["DATA_DEFAULT"],"null"=>($J["NULLABLE"]=="Y"),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);}return$I;}function
indexes($R,$h=null){$I=array();foreach(get_rows("SELECT uic.*, uc.constraint_type
FROM user_ind_columns uic
LEFT JOIN user_constraints uc ON uic.index_name = uc.constraint_name AND uic.table_name = uc.table_name
WHERE uic.table_name = ".q($R)."
ORDER BY uc.constraint_type, uic.column_position",$h)as$J){$Dd=$J["INDEX_NAME"];$I[$Dd]["type"]=($J["CONSTRAINT_TYPE"]=="P"?"PRIMARY":($J["CONSTRAINT_TYPE"]=="U"?"UNIQUE":"INDEX"));$I[$Dd]["columns"][]=$J["COLUMN_NAME"];$I[$Dd]["lengths"][]=($J["CHAR_LENGTH"]&&$J["CHAR_LENGTH"]!=$J["COLUMN_LENGTH"]?$J["CHAR_LENGTH"]:null);$I[$Dd]["descs"][]=($J["DESCEND"]?'1':null);}return$I;}function
view($C){$K=get_rows('SELECT text "select" FROM user_views WHERE view_name = '.q($C));return
reset($K);}function
collations(){return
array();}function
information_schema($m){return
false;}function
error(){global$g;return
h($g->error);}function
explain($g,$G){$g->query("EXPLAIN PLAN FOR $G");return$g->query("SELECT * FROM plan_table");}function
found_rows($S,$Z){}function
alter_table($R,$C,$q,$bd,$vb,$uc,$pb,$Ma,$Nf){$c=$fc=array();foreach($q
as$p){$X=$p[1];if($X&&$p[0]!=""&&idf_escape($p[0])!=$X[0])queries("ALTER TABLE ".table($R)." RENAME COLUMN ".idf_escape($p[0])." TO $X[0]");if($X)$c[]=($R!=""?($p[0]!=""?"MODIFY (":"ADD ("):"  ").implode($X).($R!=""?")":"");else$fc[]=idf_escape($p[0]);}if($R=="")return
queries("CREATE TABLE ".table($C)." (\n".implode(",\n",$c)."\n)");return(!$c||queries("ALTER TABLE ".table($R)."\n".implode("\n",$c)))&&(!$fc||queries("ALTER TABLE ".table($R)." DROP (".implode(", ",$fc).")"))&&($R==$C||queries("ALTER TABLE ".table($R)." RENAME TO ".table($C)));}function
foreign_keys($R){$I=array();$G="SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = ".q($R);foreach(get_rows($G)as$J)$I[$J['NAME']]=array("db"=>$J['DEST_DB'],"table"=>$J['DEST_TABLE'],"source"=>array($J['SRC_COLUMN']),"target"=>array($J['DEST_COLUMN']),"on_delete"=>$J['ON_DELETE'],"on_update"=>null,);return$I;}function
truncate_tables($T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views($Ri){return
apply_queries("DROP VIEW",$Ri);}function
drop_tables($T){return
apply_queries("DROP TABLE",$T);}function
last_id(){return
0;}function
schemas(){return
get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX'))");}function
get_schema(){global$g;return$g->result("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");}function
set_schema($Ug){global$g;return$g->query("ALTER SESSION SET CURRENT_SCHEMA = ".idf_escape($Ug));}function
show_variables(){return
get_key_vals('SELECT name, display_value FROM v$parameter');}function
process_list(){return
get_rows('SELECT sess.process AS "process", sess.username AS "user", sess.schemaname AS "schema", sess.status AS "status", sess.wait_class AS "wait_class", sess.seconds_in_wait AS "seconds_in_wait", sql.sql_text AS "sql_text", sess.machine AS "machine", sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');}function
show_status(){$K=get_rows('SELECT * FROM v$instance');return
reset($K);}function
convert_field($p){}function
unconvert_field($p,$I){return$I;}function
support($Pc){return
preg_match('~^(columns|database|drop_col|indexes|processlist|scheme|sql|status|table|variables|view|view_trigger)$~',$Pc);}$y="oracle";$ui=array();$zh=array();foreach(array(lang(25)=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),lang(26)=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),lang(23)=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),lang(27)=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),)as$z=>$X){$ui+=$X;$zh[$z]=array_keys($X);}$Ai=array();$pf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");$jd=array("length","lower","round","upper");$pd=array("avg","count","count distinct","max","min","sum");$mc=array(array("date"=>"current_date","timestamp"=>"current_timestamp",),array("number|float|double"=>"+/-","date|timestamp"=>"+ interval/- interval","char|clob"=>"||",));}$ec["mssql"]="MS SQL";if(isset($_GET["mssql"])){$ag=array("SQLSRV","MSSQL","PDO_DBLIB");define("DRIVER","mssql");if(extension_loaded("sqlsrv")){class
Min_DB{var$extension="sqlsrv",$_link,$_result,$server_info,$affected_rows,$errno,$error;function
_get_error(){$this->error="";foreach(sqlsrv_errors()as$o){$this->errno=$o["code"];$this->error.="$o[message]\n";}$this->error=rtrim($this->error);}function
connect($N,$V,$F){$this->_link=@sqlsrv_connect($N,array("UID"=>$V,"PWD"=>$F,"CharacterSet"=>"UTF-8"));if($this->_link){$Kd=sqlsrv_server_info($this->_link);$this->server_info=$Kd['SQLServerVersion'];}else$this->_get_error();return(bool)$this->_link;}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}function
select_db($k){return$this->query("USE ".idf_escape($k));}function
query($G,$vi=false){$H=sqlsrv_query($this->_link,$G);$this->error="";if(!$H){$this->_get_error();return
false;}return$this->store_result($H);}function
multi_query($G){$this->_result=sqlsrv_query($this->_link,$G);$this->error="";if(!$this->_result){$this->_get_error();return
false;}return
true;}function
store_result($H=null){if(!$H)$H=$this->_result;if(!$H)return
false;if(sqlsrv_field_metadata($H))return
new
Min_Result($H);$this->affected_rows=sqlsrv_rows_affected($H);return
true;}function
next_result(){return$this->_result?sqlsrv_next_result($this->_result):null;}function
result($G,$p=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->fetch_row();return$J[$p];}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($H){$this->_result=$H;}function
_convert($J){foreach((array)$J
as$z=>$X){if(is_a($X,'DateTime'))$J[$z]=$X->format("Y-m-d H:i:s");}return$J;}function
fetch_assoc(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_ASSOC));}function
fetch_row(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_NUMERIC));}function
fetch_field(){if(!$this->_fields)$this->_fields=sqlsrv_field_metadata($this->_result);$p=$this->_fields[$this->_offset++];$I=new
stdClass;$I->name=$p["Name"];$I->orgname=$p["Name"];$I->type=($p["Type"]==1?254:0);return$I;}function
seek($D){for($t=0;$t<$D;$t++)sqlsrv_fetch($this->_result);}function
__destruct(){sqlsrv_free_stmt($this->_result);}}}elseif(extension_loaded("mssql")){class
Min_DB{var$extension="MSSQL",$_link,$_result,$server_info,$affected_rows,$error;function
connect($N,$V,$F){$this->_link=@mssql_connect($N,$V,$F);if($this->_link){$H=$this->query("SELECT SERVERPROPERTY('ProductLevel'), SERVERPROPERTY('Edition')");$J=$H->fetch_row();$this->server_info=$this->result("sp_server_info 2",2)." [$J[0]] $J[1]";}else$this->error=mssql_get_last_message();return(bool)$this->_link;}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}function
select_db($k){return
mssql_select_db($k);}function
query($G,$vi=false){$H=@mssql_query($G,$this->_link);$this->error="";if(!$H){$this->error=mssql_get_last_message();return
false;}if($H===true){$this->affected_rows=mssql_rows_affected($this->_link);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
mssql_next_result($this->_result->_result);}function
result($G,$p=0){$H=$this->query($G);if(!is_object($H))return
false;return
mssql_result($H->_result,0,$p);}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($H){$this->_result=$H;$this->num_rows=mssql_num_rows($H);}function
fetch_assoc(){return
mssql_fetch_assoc($this->_result);}function
fetch_row(){return
mssql_fetch_row($this->_result);}function
num_rows(){return
mssql_num_rows($this->_result);}function
fetch_field(){$I=mssql_fetch_field($this->_result);$I->orgtable=$I->table;$I->orgname=$I->name;return$I;}function
seek($D){mssql_data_seek($this->_result,$D);}function
__destruct(){mssql_free_result($this->_result);}}}elseif(extension_loaded("pdo_dblib")){class
Min_DB
extends
Min_PDO{var$extension="PDO_DBLIB";function
connect($N,$V,$F){$this->dsn("dblib:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\\d)~',';port=\\1',$N)),$V,$F);return
true;}function
select_db($k){return$this->query("USE ".idf_escape($k));}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($R,$K,$dg){foreach($K
as$O){$Bi=array();$Z=array();foreach($O
as$z=>$X){$Bi[]="$z = $X";if(isset($dg[idf_unescape($z)]))$Z[]="$z = $X";}if(!queries("MERGE ".table($R)." USING (VALUES(".implode(", ",$O).")) AS source (c".implode(", c",range(1,count($O))).") ON ".implode(" AND ",$Z)." WHEN MATCHED THEN UPDATE SET ".implode(", ",$Bi)." WHEN NOT MATCHED THEN INSERT (".implode(", ",array_keys($O)).") VALUES (".implode(", ",$O).");"))return
false;}return
true;}function
begin(){return
queries("BEGIN TRANSACTION");}}function
idf_escape($v){return"[".str_replace("]","]]",$v)."]";}function
table($v){return($_GET["ns"]!=""?idf_escape($_GET["ns"]).".":"").idf_escape($v);}function
connect(){global$b;$g=new
Min_DB;$j=$b->credentials();if($g->connect($j[0],$j[1],$j[2]))return$g;return$g->error;}function
get_databases(){return
get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");}function
limit($G,$Z,$_,$D=0,$M=" "){return($_!==null?" TOP (".($_+$D).")":"")." $G$Z";}function
limit1($R,$G,$Z,$M="\n"){return
limit($G,$Z,1,0,$M);}function
db_collation($m,$qb){global$g;return$g->result("SELECT collation_name FROM sys.databases WHERE name = ".q($m));}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT SUSER_NAME()");}function
tables_list(){return
get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ORDER BY name");}function
count_tables($l){global$g;$I=array();foreach($l
as$m){$g->select_db($m);$I[$m]=$g->result("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");}return$I;}function
table_status($C=""){$I=array();foreach(get_rows("SELECT name AS Name, type_desc AS Engine FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ".($C!=""?"AND name = ".q($C):"ORDER BY name"))as$J){if($C!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($S){return$S["Engine"]=="VIEW";}function
fk_support($S){return
true;}function
fields($R){$I=array();foreach(get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default]
FROM sys.all_columns c
JOIN sys.all_objects o ON c.object_id = o.object_id
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.parent_column_id
WHERE o.schema_id = SCHEMA_ID(".q(get_schema()).") AND o.type IN ('S', 'U', 'V') AND o.name = ".q($R))as$J){$U=$J["type"];$pe=(preg_match("~char|binary~",$U)?$J["max_length"]:($U=="decimal"?"$J[precision],$J[scale]":""));$I[$J["name"]]=array("field"=>$J["name"],"full_type"=>$U.($pe?"($pe)":""),"type"=>$U,"length"=>$pe,"default"=>$J["default"],"null"=>$J["is_nullable"],"auto_increment"=>$J["is_identity"],"collation"=>$J["collation_name"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),"primary"=>$J["is_identity"],);}return$I;}function
indexes($R,$h=null){$I=array();foreach(get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = ".q($R),$h)as$J){$C=$J["name"];$I[$C]["type"]=($J["is_primary_key"]?"PRIMARY":($J["is_unique"]?"UNIQUE":"INDEX"));$I[$C]["lengths"]=array();$I[$C]["columns"][$J["key_ordinal"]]=$J["column_name"];$I[$C]["descs"][$J["key_ordinal"]]=($J["is_descending_key"]?'1':null);}return$I;}function
view($C){global$g;return
array("select"=>preg_replace('~^(?:[^[]|\\[[^]]*])*\\s+AS\\s+~isU','',$g->result("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = ".q($C))));}function
collations(){$I=array();foreach(get_vals("SELECT name FROM fn_helpcollations()")as$pb)$I[preg_replace('~_.*~','',$pb)][]=$pb;return$I;}function
information_schema($m){return
false;}function
error(){global$g;return
nl_br(h(preg_replace('~^(\\[[^]]*])+~m','',$g->error)));}function
create_database($m,$pb){return
queries("CREATE DATABASE ".idf_escape($m).(preg_match('~^[a-z0-9_]+$~i',$pb)?" COLLATE $pb":""));}function
drop_databases($l){return
queries("DROP DATABASE ".implode(", ",array_map('idf_escape',$l)));}function
rename_database($C,$pb){if(preg_match('~^[a-z0-9_]+$~i',$pb))queries("ALTER DATABASE ".idf_escape(DB)." COLLATE $pb");queries("ALTER DATABASE ".idf_escape(DB)." MODIFY NAME = ".idf_escape($C));return
true;}function
auto_increment(){return" IDENTITY".($_POST["Auto_increment"]!=""?"(".number($_POST["Auto_increment"]).",1)":"")." PRIMARY KEY";}function
alter_table($R,$C,$q,$bd,$vb,$uc,$pb,$Ma,$Nf){$c=array();foreach($q
as$p){$d=idf_escape($p[0]);$X=$p[1];if(!$X)$c["DROP"][]=" COLUMN $d";else{$X[1]=preg_replace("~( COLLATE )'(\\w+)'~","\\1\\2",$X[1]);if($p[0]=="")$c["ADD"][]="\n  ".implode("",$X).($R==""?substr($bd[$X[0]],16+strlen($X[0])):"");else{unset($X[6]);if($d!=$X[0])queries("EXEC sp_rename ".q(table($R).".$d").", ".q(idf_unescape($X[0])).", 'COLUMN'");$c["ALTER COLUMN ".implode("",$X)][]="";}}}if($R=="")return
queries("CREATE TABLE ".table($C)." (".implode(",",(array)$c["ADD"])."\n)");if($R!=$C)queries("EXEC sp_rename ".q(table($R)).", ".q($C));if($bd)$c[""]=$bd;foreach($c
as$z=>$X){if(!queries("ALTER TABLE ".idf_escape($C)." $z".implode(",",$X)))return
false;}return
true;}function
alter_indexes($R,$c){$w=array();$fc=array();foreach($c
as$X){if($X[2]=="DROP"){if($X[0]=="PRIMARY")$fc[]=idf_escape($X[1]);else$w[]=idf_escape($X[1])." ON ".table($R);}elseif(!queries(($X[0]!="PRIMARY"?"CREATE $X[0] ".($X[0]!="INDEX"?"INDEX ":"").idf_escape($X[1]!=""?$X[1]:uniqid($R."_"))." ON ".table($R):"ALTER TABLE ".table($R)." ADD PRIMARY KEY")." (".implode(", ",$X[2]).")"))return
false;}return(!$w||queries("DROP INDEX ".implode(", ",$w)))&&(!$fc||queries("ALTER TABLE ".table($R)." DROP ".implode(", ",$fc)));}function
last_id(){global$g;return$g->result("SELECT SCOPE_IDENTITY()");}function
explain($g,$G){$g->query("SET SHOWPLAN_ALL ON");$I=$g->query($G);$g->query("SET SHOWPLAN_ALL OFF");return$I;}function
found_rows($S,$Z){}function
foreign_keys($R){$I=array();foreach(get_rows("EXEC sp_fkeys @fktable_name = ".q($R))as$J){$r=&$I[$J["FK_NAME"]];$r["table"]=$J["PKTABLE_NAME"];$r["source"][]=$J["FKCOLUMN_NAME"];$r["target"][]=$J["PKCOLUMN_NAME"];}return$I;}function
truncate_tables($T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views($Ri){return
queries("DROP VIEW ".implode(", ",array_map('table',$Ri)));}function
drop_tables($T){return
queries("DROP TABLE ".implode(", ",array_map('table',$T)));}function
move_tables($T,$Ri,$Oh){return
apply_queries("ALTER SCHEMA ".idf_escape($Oh)." TRANSFER",array_merge($T,$Ri));}function
trigger($C){if($C=="")return
array();$K=get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = ".q($C));$I=reset($K);if($I)$I["Statement"]=preg_replace('~^.+\\s+AS\\s+~isU','',$I["text"]);return$I;}function
triggers($R){$I=array();foreach(get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = ".q($R))as$J)$I[$J["name"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("AS"),);}function
schemas(){return
get_vals("SELECT name FROM sys.schemas");}function
get_schema(){global$g;if($_GET["ns"]!="")return$_GET["ns"];return$g->result("SELECT SCHEMA_NAME()");}function
set_schema($Tg){return
true;}function
use_sql($k){return"USE ".idf_escape($k);}function
show_variables(){return
array();}function
show_status(){return
array();}function
convert_field($p){}function
unconvert_field($p,$I){return$I;}function
support($Pc){return
preg_match('~^(columns|database|drop_col|indexes|scheme|sql|table|trigger|view|view_trigger)$~',$Pc);}$y="mssql";$ui=array();$zh=array();foreach(array(lang(25)=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),lang(26)=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),lang(23)=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),lang(27)=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),)as$z=>$X){$ui+=$X;$zh[$z]=array_keys($X);}$Ai=array();$pf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");$jd=array("len","lower","round","upper");$pd=array("avg","count","count distinct","max","min","sum");$mc=array(array("date|time"=>"getdate",),array("int|decimal|real|float|money|datetime"=>"+/-","char|text"=>"+",));}$ec['firebird']='Firebird (alpha)';if(isset($_GET["firebird"])){$ag=array("interbase");define("DRIVER","firebird");if(extension_loaded("interbase")){class
Min_DB{var$extension="Firebird",$server_info,$affected_rows,$errno,$error,$_link,$_result;function
connect($N,$V,$F){$this->_link=ibase_connect($N,$V,$F);if($this->_link){$Ei=explode(':',$N);$this->service_link=ibase_service_attach($Ei[0],$V,$F);$this->server_info=ibase_server_info($this->service_link,IBASE_SVC_SERVER_VERSION);}else{$this->errno=ibase_errcode();$this->error=ibase_errmsg();}return(bool)$this->_link;}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}function
select_db($k){return($k=="domain");}function
query($G,$vi=false){$H=ibase_query($G,$this->_link);if(!$H){$this->errno=ibase_errcode();$this->error=ibase_errmsg();return
false;}$this->error="";if($H===true){$this->affected_rows=ibase_affected_rows($this->_link);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$p=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;$J=$H->fetch_row();return$J[$p];}}class
Min_Result{var$num_rows,$_result,$_offset=0;function
__construct($H){$this->_result=$H;}function
fetch_assoc(){return
ibase_fetch_assoc($this->_result);}function
fetch_row(){return
ibase_fetch_row($this->_result);}function
fetch_field(){$p=ibase_field_info($this->_result,$this->_offset++);return(object)array('name'=>$p['name'],'orgname'=>$p['name'],'type'=>$p['type'],'charsetnr'=>$p['length'],);}function
__destruct(){ibase_free_result($this->_result);}}}class
Min_Driver
extends
Min_SQL{}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect(){global$b;$g=new
Min_DB;$j=$b->credentials();if($g->connect($j[0],$j[1],$j[2]))return$g;return$g->error;}function
get_databases($ad){return
array("domain");}function
limit($G,$Z,$_,$D=0,$M=" "){$I='';$I.=($_!==null?$M."FIRST $_".($D?" SKIP $D":""):"");$I.=" $G$Z";return$I;}function
limit1($R,$G,$Z,$M="\n"){return
limit($G,$Z,1,0,$M);}function
db_collation($m,$qb){}function
engines(){return
array();}function
logged_user(){global$b;$j=$b->credentials();return$j[1];}function
tables_list(){global$g;$G='SELECT RDB$RELATION_NAME FROM rdb$relations WHERE rdb$system_flag = 0';$H=ibase_query($g->_link,$G);$I=array();while($J=ibase_fetch_assoc($H))$I[$J['RDB$RELATION_NAME']]='table';ksort($I);return$I;}function
count_tables($l){return
array();}function
table_status($C="",$Oc=false){global$g;$I=array();$Lb=tables_list();foreach($Lb
as$w=>$X){$w=trim($w);$I[$w]=array('Name'=>$w,'Engine'=>'standard',);if($C==$w)return$I[$w];}return$I;}function
is_view($S){return
false;}function
fk_support($S){return
preg_match('~InnoDB|IBMDB2I~i',$S["Engine"]);}function
fields($R){global$g;$I=array();$G='SELECT r.RDB$FIELD_NAME AS field_name,
r.RDB$DESCRIPTION AS field_description,
r.RDB$DEFAULT_VALUE AS field_default_value,
r.RDB$NULL_FLAG AS field_not_null_constraint,
f.RDB$FIELD_LENGTH AS field_length,
f.RDB$FIELD_PRECISION AS field_precision,
f.RDB$FIELD_SCALE AS field_scale,
CASE f.RDB$FIELD_TYPE
WHEN 261 THEN \'BLOB\'
WHEN 14 THEN \'CHAR\'
WHEN 40 THEN \'CSTRING\'
WHEN 11 THEN \'D_FLOAT\'
WHEN 27 THEN \'DOUBLE\'
WHEN 10 THEN \'FLOAT\'
WHEN 16 THEN \'INT64\'
WHEN 8 THEN \'INTEGER\'
WHEN 9 THEN \'QUAD\'
WHEN 7 THEN \'SMALLINT\'
WHEN 12 THEN \'DATE\'
WHEN 13 THEN \'TIME\'
WHEN 35 THEN \'TIMESTAMP\'
WHEN 37 THEN \'VARCHAR\'
ELSE \'UNKNOWN\'
END AS field_type,
f.RDB$FIELD_SUB_TYPE AS field_subtype,
coll.RDB$COLLATION_NAME AS field_collation,
cset.RDB$CHARACTER_SET_NAME AS field_charset
FROM RDB$RELATION_FIELDS r
LEFT JOIN RDB$FIELDS f ON r.RDB$FIELD_SOURCE = f.RDB$FIELD_NAME
LEFT JOIN RDB$COLLATIONS coll ON f.RDB$COLLATION_ID = coll.RDB$COLLATION_ID
LEFT JOIN RDB$CHARACTER_SETS cset ON f.RDB$CHARACTER_SET_ID = cset.RDB$CHARACTER_SET_ID
WHERE r.RDB$RELATION_NAME = '.q($R).'
ORDER BY r.RDB$FIELD_POSITION';$H=ibase_query($g->_link,$G);while($J=ibase_fetch_assoc($H))$I[trim($J['FIELD_NAME'])]=array("field"=>trim($J["FIELD_NAME"]),"full_type"=>trim($J["FIELD_TYPE"]),"type"=>trim($J["FIELD_SUB_TYPE"]),"default"=>trim($J['FIELD_DEFAULT_VALUE']),"null"=>(trim($J["FIELD_NOT_NULL_CONSTRAINT"])=="YES"),"auto_increment"=>'0',"collation"=>trim($J["FIELD_COLLATION"]),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),"comment"=>trim($J["FIELD_DESCRIPTION"]),);return$I;}function
indexes($R,$h=null){$I=array();return$I;}function
foreign_keys($R){return
array();}function
collations(){return
array();}function
information_schema($m){return
false;}function
error(){global$g;return
h($g->error);}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Tg){return
true;}function
support($Pc){return
preg_match("~^(columns|sql|status|table)$~",$Pc);}$y="firebird";$pf=array("=");$jd=array();$pd=array();$mc=array();}$ec["simpledb"]="SimpleDB";if(isset($_GET["simpledb"])){$ag=array("SimpleXML + allow_url_fopen");define("DRIVER","simpledb");if(class_exists('SimpleXMLElement')&&ini_bool('allow_url_fopen')){class
Min_DB{var$extension="SimpleXML",$server_info='2009-04-15',$error,$timeout,$next,$affected_rows,$_result;function
select_db($k){return($k=="domain");}function
query($G,$vi=false){$Hf=array('SelectExpression'=>$G,'ConsistentRead'=>'true');if($this->next)$Hf['NextToken']=$this->next;$H=sdb_request_all('Select','Item',$Hf,$this->timeout);if($H===false)return$H;if(preg_match('~^\s*SELECT\s+COUNT\(~i',$G)){$Ch=0;foreach($H
as$Wd)$Ch+=$Wd->Attribute->Value;$H=array((object)array('Attribute'=>array((object)array('Name'=>'Count','Value'=>$Ch,))));}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0;function
__construct($H){foreach($H
as$Wd){$J=array();if($Wd->Name!='')$J['itemName()']=(string)$Wd->Name;foreach($Wd->Attribute
as$Ja){$C=$this->_processValue($Ja->Name);$Y=$this->_processValue($Ja->Value);if(isset($J[$C])){$J[$C]=(array)$J[$C];$J[$C][]=$Y;}else$J[$C]=$Y;}$this->_rows[]=$J;foreach($J
as$z=>$X){if(!isset($this->_rows[0][$z]))$this->_rows[0][$z]=null;}}$this->num_rows=count($this->_rows);}function
_processValue($pc){return(is_object($pc)&&$pc['encoding']=='base64'?base64_decode($pc):(string)$pc);}function
fetch_assoc(){$J=current($this->_rows);if(!$J)return$J;$I=array();foreach($this->_rows[0]as$z=>$X)$I[$z]=$J[$z];next($this->_rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$ce=array_keys($this->_rows[0]);return(object)array('name'=>$ce[$this->_offset++]);}}}class
Min_Driver
extends
Min_SQL{public$dg="itemName()";function
_chunkRequest($Ad,$wa,$Hf,$Ec=array()){global$g;foreach(array_chunk($Ad,25)as$ib){$If=$Hf;foreach($ib
as$t=>$u){$If["Item.$t.ItemName"]=$u;foreach($Ec
as$z=>$X)$If["Item.$t.$z"]=$X;}if(!sdb_request($wa,$If))return
false;}$g->affected_rows=count($Ad);return
true;}function
_extractIds($R,$pg,$_){$I=array();if(preg_match_all("~itemName\(\) = (('[^']*+')+)~",$pg,$_e))$I=array_map('idf_unescape',$_e[1]);else{foreach(sdb_request_all('Select','Item',array('SelectExpression'=>'SELECT itemName() FROM '.table($R).$pg.($_?" LIMIT 1":"")))as$Wd)$I[]=$Wd->Name;}return$I;}function
select($R,$L,$Z,$md,$uf=array(),$_=1,$E=0,$fg=false){global$g;$g->next=$_GET["next"];$I=parent::select($R,$L,$Z,$md,$uf,$_,$E,$fg);$g->next=0;return$I;}function
delete($R,$pg,$_=0){return$this->_chunkRequest($this->_extractIds($R,$pg,$_),'BatchDeleteAttributes',array('DomainName'=>$R));}function
update($R,$O,$pg,$_=0,$M="\n"){$Ub=array();$Od=array();$t=0;$Ad=$this->_extractIds($R,$pg,$_);$u=idf_unescape($O["`itemName()`"]);unset($O["`itemName()`"]);foreach($O
as$z=>$X){$z=idf_unescape($z);if($X=="NULL"||($u!=""&&array($u)!=$Ad))$Ub["Attribute.".count($Ub).".Name"]=$z;if($X!="NULL"){foreach((array)$X
as$Yd=>$W){$Od["Attribute.$t.Name"]=$z;$Od["Attribute.$t.Value"]=(is_array($X)?$W:idf_unescape($W));if(!$Yd)$Od["Attribute.$t.Replace"]="true";$t++;}}}$Hf=array('DomainName'=>$R);return(!$Od||$this->_chunkRequest(($u!=""?array($u):$Ad),'BatchPutAttributes',$Hf,$Od))&&(!$Ub||$this->_chunkRequest($Ad,'BatchDeleteAttributes',$Hf,$Ub));}function
insert($R,$O){$Hf=array("DomainName"=>$R);$t=0;foreach($O
as$C=>$Y){if($Y!="NULL"){$C=idf_unescape($C);if($C=="itemName()")$Hf["ItemName"]=idf_unescape($Y);else{foreach((array)$Y
as$X){$Hf["Attribute.$t.Name"]=$C;$Hf["Attribute.$t.Value"]=(is_array($Y)?$X:idf_unescape($Y));$t++;}}}}return
sdb_request('PutAttributes',$Hf);}function
insertUpdate($R,$K,$dg){foreach($K
as$O){if(!$this->update($R,$O,"WHERE `itemName()` = ".q($O["`itemName()`"])))return
false;}return
true;}function
begin(){return
false;}function
commit(){return
false;}function
rollback(){return
false;}}function
connect(){return
new
Min_DB;}function
support($Pc){return
preg_match('~sql~',$Pc);}function
logged_user(){global$b;$j=$b->credentials();return$j[1];}function
get_databases(){return
array("domain");}function
collations(){return
array();}function
db_collation($m,$qb){}function
tables_list(){global$g;$I=array();foreach(sdb_request_all('ListDomains','DomainName')as$R)$I[(string)$R]='table';if($g->error&&defined("PAGE_HEADER"))echo"<p class='error'>".error()."\n";return$I;}function
table_status($C="",$Oc=false){$I=array();foreach(($C!=""?array($C=>true):tables_list())as$R=>$U){$J=array("Name"=>$R,"Auto_increment"=>"");if(!$Oc){$Me=sdb_request('DomainMetadata',array('DomainName'=>$R));if($Me){foreach(array("Rows"=>"ItemCount","Data_length"=>"ItemNamesSizeBytes","Index_length"=>"AttributeValuesSizeBytes","Data_free"=>"AttributeNamesSizeBytes",)as$z=>$X)$J[$z]=(string)$Me->$X;}}if($C!="")return$J;$I[$R]=$J;}return$I;}function
explain($g,$G){}function
error(){global$g;return
h($g->error);}function
information_schema(){}function
is_view($S){}function
indexes($R,$h=null){return
array(array("type"=>"PRIMARY","columns"=>array("itemName()")),);}function
fields($R){return
fields_from_edit();}function
foreign_keys($R){return
array();}function
table($v){return
idf_escape($v);}function
idf_escape($v){return"`".str_replace("`","``",$v)."`";}function
limit($G,$Z,$_,$D=0,$M=" "){return" $G$Z".($_!==null?$M."LIMIT $_":"");}function
unconvert_field($p,$I){return$I;}function
fk_support($S){}function
engines(){return
array();}function
alter_table($R,$C,$q,$bd,$vb,$uc,$pb,$Ma,$Nf){return($R==""&&sdb_request('CreateDomain',array('DomainName'=>$C)));}function
drop_tables($T){foreach($T
as$R){if(!sdb_request('DeleteDomain',array('DomainName'=>$R)))return
false;}return
true;}function
count_tables($l){foreach($l
as$m)return
array($m=>count(tables_list()));}function
found_rows($S,$Z){return($Z?null:$S["Rows"]);}function
last_id(){}function
hmac($Ca,$Lb,$z,$tg=false){$Va=64;if(strlen($z)>$Va)$z=pack("H*",$Ca($z));$z=str_pad($z,$Va,"\0");$Zd=$z^str_repeat("\x36",$Va);$ae=$z^str_repeat("\x5C",$Va);$I=$Ca($ae.pack("H*",$Ca($Zd.$Lb)));if($tg)$I=pack("H*",$I);return$I;}function
sdb_request($wa,$Hf=array()){global$b,$g;list($yd,$Hf['AWSAccessKeyId'],$Wg)=$b->credentials();$Hf['Action']=$wa;$Hf['Timestamp']=gmdate('Y-m-d\TH:i:s+00:00');$Hf['Version']='2009-04-15';$Hf['SignatureVersion']=2;$Hf['SignatureMethod']='HmacSHA1';ksort($Hf);$G='';foreach($Hf
as$z=>$X)$G.='&'.rawurlencode($z).'='.rawurlencode($X);$G=str_replace('%7E','~',substr($G,1));$G.="&Signature=".urlencode(base64_encode(hmac('sha1',"POST\n".preg_replace('~^https?://~','',$yd)."\n/\n$G",$Wg,true)));@ini_set('track_errors',1);$Tc=@file_get_contents((preg_match('~^https?://~',$yd)?$yd:"http://$yd"),false,stream_context_create(array('http'=>array('method'=>'POST','content'=>$G,'ignore_errors'=>1,))));if(!$Tc){$g->error=$php_errormsg;return
false;}libxml_use_internal_errors(true);$ej=simplexml_load_string($Tc);if(!$ej){$o=libxml_get_last_error();$g->error=$o->message;return
false;}if($ej->Errors){$o=$ej->Errors->Error;$g->error="$o->Message ($o->Code)";return
false;}$g->error='';$Nh=$wa."Result";return($ej->$Nh?$ej->$Nh:true);}function
sdb_request_all($wa,$Nh,$Hf=array(),$Wh=0){$I=array();$vh=($Wh?microtime(true):0);$_=(preg_match('~LIMIT\s+(\d+)\s*$~i',$Hf['SelectExpression'],$B)?$B[1]:0);do{$ej=sdb_request($wa,$Hf);if(!$ej)break;foreach($ej->$Nh
as$pc)$I[]=$pc;if($_&&count($I)>=$_){$_GET["next"]=$ej->NextToken;break;}if($Wh&&microtime(true)-$vh>$Wh)return
false;$Hf['NextToken']=$ej->NextToken;if($_)$Hf['SelectExpression']=preg_replace('~\d+\s*$~',$_-count($I),$Hf['SelectExpression']);}while($ej->NextToken);return$I;}$y="simpledb";$pf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","IS NOT NULL");$jd=array();$pd=array("count");$mc=array(array("json"));}$ec["mongo"]="MongoDB (beta)";if(isset($_GET["mongo"])){$ag=array("mongo","mongodb");define("DRIVER","mongo");if(class_exists('MongoDB')){class
Min_DB{var$extension="Mongo",$error,$last_id,$_link,$_db;function
connect($N,$V,$F){global$b;$m=$b->database();$sf=array();if($V!=""){$sf["username"]=$V;$sf["password"]=$F;}if($m!="")$sf["db"]=$m;try{$this->_link=@new
MongoClient("mongodb://$N",$sf);return
true;}catch(Exception$Ac){$this->error=$Ac->getMessage();return
false;}}function
query($G){return
false;}function
select_db($k){try{$this->_db=$this->_link->selectDB($k);return
true;}catch(Exception$Ac){$this->error=$Ac->getMessage();return
false;}}function
quote($Q){return$Q;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($H){foreach($H
as$Wd){$J=array();foreach($Wd
as$z=>$X){if(is_a($X,'MongoBinData'))$this->_charset[$z]=63;$J[$z]=(is_a($X,'MongoId')?'ObjectId("'.strval($X).'")':(is_a($X,'MongoDate')?gmdate("Y-m-d H:i:s",$X->sec)." GMT":(is_a($X,'MongoBinData')?$X->bin:(is_a($X,'MongoRegex')?strval($X):(is_object($X)?get_class($X):$X)))));}$this->_rows[]=$J;foreach($J
as$z=>$X){if(!isset($this->_rows[0][$z]))$this->_rows[0][$z]=null;}}$this->num_rows=count($this->_rows);}function
fetch_assoc(){$J=current($this->_rows);if(!$J)return$J;$I=array();foreach($this->_rows[0]as$z=>$X)$I[$z]=$J[$z];next($this->_rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$ce=array_keys($this->_rows[0]);$C=$ce[$this->_offset++];return(object)array('name'=>$C,'charsetnr'=>$this->_charset[$C],);}}class
Min_Driver
extends
Min_SQL{public$dg="_id";function
select($R,$L,$Z,$md,$uf=array(),$_=1,$E=0,$fg=false){$L=($L==array("*")?array():array_fill_keys($L,true));$mh=array();foreach($uf
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Eb);$mh[$X]=($Eb?-1:1);}return
new
Min_Result($this->_conn->_db->selectCollection($R)->find(array(),$L)->sort($mh)->limit($_!=""?+$_:0)->skip($E*$_));}function
insert($R,$O){try{$I=$this->_conn->_db->selectCollection($R)->insert($O);$this->_conn->errno=$I['code'];$this->_conn->error=$I['err'];$this->_conn->last_id=$O['_id'];return!$I['err'];}catch(Exception$Ac){$this->_conn->error=$Ac->getMessage();return
false;}}}function
get_databases($ad){global$g;$I=array();$Qb=$g->_link->listDBs();foreach($Qb['databases']as$m)$I[]=$m['name'];return$I;}function
count_tables($l){global$g;$I=array();foreach($l
as$m)$I[$m]=count($g->_link->selectDB($m)->getCollectionNames(true));return$I;}function
tables_list(){global$g;return
array_fill_keys($g->_db->getCollectionNames(true),'table');}function
drop_databases($l){global$g;foreach($l
as$m){$Fg=$g->_link->selectDB($m)->drop();if(!$Fg['ok'])return
false;}return
true;}function
indexes($R,$h=null){global$g;$I=array();foreach($g->_db->selectCollection($R)->getIndexInfo()as$w){$Xb=array();foreach($w["key"]as$d=>$U)$Xb[]=($U==-1?'1':null);$I[$w["name"]]=array("type"=>($w["name"]=="_id_"?"PRIMARY":($w["unique"]?"UNIQUE":"INDEX")),"columns"=>array_keys($w["key"]),"lengths"=>array(),"descs"=>$Xb,);}return$I;}function
fields($R){return
fields_from_edit();}function
found_rows($S,$Z){global$g;return$g->_db->selectCollection($_GET["select"])->count($Z);}$pf=array("=");}elseif(class_exists('MongoDB\Driver\Manager')){class
Min_DB{var$extension="MongoDB",$error,$last_id;var$_link;var$_db,$_db_name;function
connect($N,$V,$F){global$b;$m=$b->database();$sf=array();if($V!=""){$sf["username"]=$V;$sf["password"]=$F;}if($m!="")$sf["db"]=$m;try{$kb='MongoDB\Driver\Manager';$this->_link=new$kb("mongodb://$N",$sf);return
true;}catch(Exception$Ac){$this->error=$Ac->getMessage();return
false;}}function
query($G){return
false;}function
select_db($k){try{$this->_db_name=$k;return
true;}catch(Exception$Ac){$this->error=$Ac->getMessage();return
false;}}function
quote($Q){return$Q;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($H){foreach($H
as$Wd){$J=array();foreach($Wd
as$z=>$X){if(is_a($X,'MongoDB\BSON\Binary'))$this->_charset[$z]=63;$J[$z]=(is_a($X,'MongoDB\BSON\ObjectID')?'MongoDB\BSON\ObjectID("'.strval($X).'")':(is_a($X,'MongoDB\BSON\UTCDatetime')?$X->toDateTime()->format('Y-m-d H:i:s'):(is_a($X,'MongoDB\BSON\Binary')?$X->bin:(is_a($X,'MongoDB\BSON\Regex')?strval($X):(is_object($X)?json_encode($X,256):$X)))));}$this->_rows[]=$J;foreach($J
as$z=>$X){if(!isset($this->_rows[0][$z]))$this->_rows[0][$z]=null;}}$this->num_rows=$H->count;}function
fetch_assoc(){$J=current($this->_rows);if(!$J)return$J;$I=array();foreach($this->_rows[0]as$z=>$X)$I[$z]=$J[$z];next($this->_rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$ce=array_keys($this->_rows[0]);$C=$ce[$this->_offset++];return(object)array('name'=>$C,'charsetnr'=>$this->_charset[$C],);}}class
Min_Driver
extends
Min_SQL{public$dg="_id";function
select($R,$L,$Z,$md,$uf=array(),$_=1,$E=0,$fg=false){global$g;$L=($L==array("*")?array():array_fill_keys($L,1));if(count($L)&&!isset($L['_id']))$L['_id']=0;$Z=where_to_query($Z);$mh=array();foreach($uf
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Eb);$mh[$X]=($Eb?-1:1);}if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>0)$_=$_GET['limit'];$_=min(200,max(1,(int)$_));$kh=$E*$_;$kb='MongoDB\Driver\Query';$G=new$kb($Z,array('projection'=>$L,'limit'=>$_,'skip'=>$kh,'sort'=>$mh));$Ig=$g->_link->executeQuery("$g->_db_name.$R",$G);return
new
Min_Result($Ig);}function
update($R,$O,$pg,$_=0,$M="\n"){global$g;$m=$g->_db_name;$Z=sql_query_where_parser($pg);$kb='MongoDB\Driver\BulkWrite';$Za=new$kb(array());if(isset($O['_id']))unset($O['_id']);$Cg=array();foreach($O
as$z=>$Y){if($Y=='NULL'){$Cg[$z]=1;unset($O[$z]);}}$Bi=array('$set'=>$O);if(count($Cg))$Bi['$unset']=$Cg;$Za->update($Z,$Bi,array('upsert'=>false));$Ig=$g->_link->executeBulkWrite("$m.$R",$Za);$g->affected_rows=$Ig->getModifiedCount();return
true;}function
delete($R,$pg,$_=0){global$g;$m=$g->_db_name;$Z=sql_query_where_parser($pg);$kb='MongoDB\Driver\BulkWrite';$Za=new$kb(array());$Za->delete($Z,array('limit'=>$_));$Ig=$g->_link->executeBulkWrite("$m.$R",$Za);$g->affected_rows=$Ig->getDeletedCount();return
true;}function
insert($R,$O){global$g;$m=$g->_db_name;$kb='MongoDB\Driver\BulkWrite';$Za=new$kb(array());if(isset($O['_id'])&&empty($O['_id']))unset($O['_id']);$Za->insert($O);$Ig=$g->_link->executeBulkWrite("$m.$R",$Za);$g->affected_rows=$Ig->getInsertedCount();return
true;}}function
get_databases($ad){global$g;$I=array();$kb='MongoDB\Driver\Command';$tb=new$kb(array('listDatabases'=>1));$Ig=$g->_link->executeCommand('admin',$tb);foreach($Ig
as$Qb){foreach($Qb->databases
as$m)$I[]=$m->name;}return$I;}function
count_tables($l){$I=array();return$I;}function
tables_list(){global$g;$kb='MongoDB\Driver\Command';$tb=new$kb(array('listCollections'=>1));$Ig=$g->_link->executeCommand($g->_db_name,$tb);$rb=array();foreach($Ig
as$H)$rb[$H->name]='table';return$rb;}function
drop_databases($l){return
false;}function
indexes($R,$h=null){global$g;$I=array();$kb='MongoDB\Driver\Command';$tb=new$kb(array('listIndexes'=>$R));$Ig=$g->_link->executeCommand($g->_db_name,$tb);foreach($Ig
as$w){$Xb=array();$e=array();foreach(get_object_vars($w->key)as$d=>$U){$Xb[]=($U==-1?'1':null);$e[]=$d;}$I[$w->name]=array("type"=>($w->name=="_id_"?"PRIMARY":(isset($w->unique)?"UNIQUE":"INDEX")),"columns"=>$e,"lengths"=>array(),"descs"=>$Xb,);}return$I;}function
fields($R){$q=fields_from_edit();if(!count($q)){global$n;$H=$n->select($R,array("*"),null,null,array(),10);while($J=$H->fetch_assoc()){foreach($J
as$z=>$X){$J[$z]=null;$q[$z]=array("field"=>$z,"type"=>"string","null"=>($z!=$n->primary),"auto_increment"=>($z==$n->primary),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,),);}}}return$q;}function
found_rows($S,$Z){global$g;$Z=where_to_query($Z);$kb='MongoDB\Driver\Command';$tb=new$kb(array('count'=>$S['Name'],'query'=>$Z));$Ig=$g->_link->executeCommand($g->_db_name,$tb);$ei=$Ig->toArray();return$ei[0]->n;}function
sql_query_where_parser($pg){$pg=trim(preg_replace('/WHERE[\s]?[(]?\(?/','',$pg));$pg=preg_replace('/\)\)\)$/',')',$pg);$bj=explode(' AND ',$pg);$cj=explode(') OR (',$pg);$Z=array();foreach($bj
as$Zi)$Z[]=trim($Zi);if(count($cj)==1)$cj=array();elseif(count($cj)>1)$Z=array();return
where_to_query($Z,$cj);}function
where_to_query($Xi=array(),$Yi=array()){global$pf;$Lb=array();foreach(array('and'=>$Xi,'or'=>$Yi)as$U=>$Z){if(is_array($Z)){foreach($Z
as$Hc){list($nb,$nf,$X)=explode(" ",$Hc,3);if($nb=="_id"){$X=str_replace('MongoDB\BSON\ObjectID("',"",$X);$X=str_replace('")',"",$X);$kb='MongoDB\BSON\ObjectID';$X=new$kb($X);}if(!in_array($nf,$pf))continue;if(preg_match('~^\(f\)(.+)~',$nf,$B)){$X=(float)$X;$nf=$B[1];}elseif(preg_match('~^\(date\)(.+)~',$nf,$B)){$Nb=new
DateTime($X);$kb='MongoDB\BSON\UTCDatetime';$X=new$kb($Nb->getTimestamp()*1000);$nf=$B[1];}switch($nf){case'=':$nf='$eq';break;case'!=':$nf='$ne';break;case'>':$nf='$gt';break;case'<':$nf='$lt';break;case'>=':$nf='$gte';break;case'<=':$nf='$lte';break;case'regex':$nf='$regex';break;default:continue;}if($U=='and')$Lb['$and'][]=array($nb=>array($nf=>$X));elseif($U=='or')$Lb['$or'][]=array($nb=>array($nf=>$X));}}}return$Lb;}$pf=array("=","!=",">","<",">=","<=","regex","(f)=","(f)!=","(f)>","(f)<","(f)>=","(f)<=","(date)=","(date)!=","(date)>","(date)<","(date)>=","(date)<=",);}function
table($v){return$v;}function
idf_escape($v){return$v;}function
table_status($C="",$Oc=false){$I=array();foreach(tables_list()as$R=>$U){$I[$R]=array("Name"=>$R);if($C==$R)return$I[$R];}return$I;}function
last_id(){global$g;return$g->last_id;}function
error(){global$g;return
h($g->error);}function
collations(){return
array();}function
logged_user(){global$b;$j=$b->credentials();return$j[1];}function
connect(){global$b;$g=new
Min_DB;$j=$b->credentials();if($g->connect($j[0],$j[1],$j[2]))return$g;return$g->error;}function
alter_indexes($R,$c){global$g;foreach($c
as$X){list($U,$C,$O)=$X;if($O=="DROP")$I=$g->_db->command(array("deleteIndexes"=>$R,"index"=>$C));else{$e=array();foreach($O
as$d){$d=preg_replace('~ DESC$~','',$d,1,$Eb);$e[$d]=($Eb?-1:1);}$I=$g->_db->selectCollection($R)->ensureIndex($e,array("unique"=>($U=="UNIQUE"),"name"=>$C,));}if($I['errmsg']){$g->error=$I['errmsg'];return
false;}}return
true;}function
support($Pc){return
preg_match("~database|indexes~",$Pc);}function
db_collation($m,$qb){}function
information_schema(){}function
is_view($S){}function
convert_field($p){}function
unconvert_field($p,$I){return$I;}function
foreign_keys($R){return
array();}function
fk_support($S){}function
engines(){return
array();}function
alter_table($R,$C,$q,$bd,$vb,$uc,$pb,$Ma,$Nf){global$g;if($R==""){$g->_db->createCollection($C);return
true;}}function
drop_tables($T){global$g;foreach($T
as$R){$Fg=$g->_db->selectCollection($R)->drop();if(!$Fg['ok'])return
false;}return
true;}function
truncate_tables($T){global$g;foreach($T
as$R){$Fg=$g->_db->selectCollection($R)->remove();if(!$Fg['ok'])return
false;}return
true;}$y="mongo";$jd=array();$pd=array();$mc=array(array("json"));}$ec["elastic"]="Elasticsearch (beta)";if(isset($_GET["elastic"])){$ag=array("json");define("DRIVER","elastic");if(function_exists('json_decode')){class
Min_DB{var$extension="JSON",$server_info,$errno,$error,$_url;function
rootQuery($Rf,$_b=array(),$Ne='GET'){@ini_set('track_errors',1);$Tc=@file_get_contents("$this->_url/".ltrim($Rf,'/'),false,stream_context_create(array('http'=>array('method'=>$Ne,'content'=>$_b===null?$_b:json_encode($_b),'header'=>'Content-Type: application/json','ignore_errors'=>1,))));if(!$Tc){$this->error=$php_errormsg;return$Tc;}if(!preg_match('~^HTTP/[0-9.]+ 2~i',$http_response_header[0])){$this->error=$Tc;return
false;}$I=json_decode($Tc,true);if($I===null){$this->errno=json_last_error();if(function_exists('json_last_error_msg'))$this->error=json_last_error_msg();else{$zb=get_defined_constants(true);foreach($zb['json']as$C=>$Y){if($Y==$this->errno&&preg_match('~^JSON_ERROR_~',$C)){$this->error=$C;break;}}}}return$I;}function
query($Rf,$_b=array(),$Ne='GET'){return$this->rootQuery(($this->_db!=""?"$this->_db/":"/").ltrim($Rf,'/'),$_b,$Ne);}function
connect($N,$V,$F){preg_match('~^(https?://)?(.*)~',$N,$B);$this->_url=($B[1]?$B[1]:"http://")."$V:$F@$B[2]";$I=$this->query('');if($I)$this->server_info=$I['version']['number'];return(bool)$I;}function
select_db($k){$this->_db=$k;return
true;}function
quote($Q){return$Q;}}class
Min_Result{var$num_rows,$_rows;function
__construct($K){$this->num_rows=count($this->_rows);$this->_rows=$K;reset($this->_rows);}function
fetch_assoc(){$I=current($this->_rows);next($this->_rows);return$I;}function
fetch_row(){return
array_values($this->fetch_assoc());}}}class
Min_Driver
extends
Min_SQL{function
select($R,$L,$Z,$md,$uf=array(),$_=1,$E=0,$fg=false){global$b;$Lb=array();$G="$R/_search";if($L!=array("*"))$Lb["fields"]=$L;if($uf){$mh=array();foreach($uf
as$nb){$nb=preg_replace('~ DESC$~','',$nb,1,$Eb);$mh[]=($Eb?array($nb=>"desc"):$nb);}$Lb["sort"]=$mh;}if($_){$Lb["size"]=+$_;if($E)$Lb["from"]=($E*$_);}foreach($Z
as$X){list($nb,$nf,$X)=explode(" ",$X,3);if($nb=="_id")$Lb["query"]["ids"]["values"][]=$X;elseif($nb.$X!=""){$Rh=array("term"=>array(($nb!=""?$nb:"_all")=>$X));if($nf=="=")$Lb["query"]["filtered"]["filter"]["and"][]=$Rh;else$Lb["query"]["filtered"]["query"]["bool"]["must"][]=$Rh;}}if($Lb["query"]&&!$Lb["query"]["filtered"]["query"]&&!$Lb["query"]["ids"])$Lb["query"]["filtered"]["query"]=array("match_all"=>array());$vh=microtime(true);$Vg=$this->_conn->query($G,$Lb);if($fg)echo$b->selectQuery("$G: ".print_r($Lb,true),$vh,!$Vg);if(!$Vg)return
false;$I=array();foreach($Vg['hits']['hits']as$xd){$J=array();if($L==array("*"))$J["_id"]=$xd["_id"];$q=$xd['_source'];if($L!=array("*")){$q=array();foreach($L
as$z)$q[$z]=$xd['fields'][$z];}foreach($q
as$z=>$X){if($Lb["fields"])$X=$X[0];$J[$z]=(is_array($X)?json_encode($X):$X);}$I[]=$J;}return
new
Min_Result($I);}function
update($U,$ug,$pg){$Pf=preg_split('~ *= *~',$pg);if(count($Pf)==2){$u=trim($Pf[1]);$G="$U/$u";return$this->_conn->query($G,$ug,'POST');}return
false;}function
insert($U,$ug){$u="";$G="$U/$u";$Fg=$this->_conn->query($G,$ug,'POST');$this->_conn->last_id=$Fg['_id'];return$Fg['created'];}function
delete($U,$pg){$Ad=array();if(is_array($_GET["where"])&&$_GET["where"]["_id"])$Ad[]=$_GET["where"]["_id"];if(is_array($_POST['check'])){foreach($_POST['check']as$db){$Pf=preg_split('~ *= *~',$db);if(count($Pf)==2)$Ad[]=trim($Pf[1]);}}$this->_conn->affected_rows=0;foreach($Ad
as$u){$G="{$U}/{$u}";$Fg=$this->_conn->query($G,'{}','DELETE');if(is_array($Fg)&&$Fg['found']==true)$this->_conn->affected_rows++;}return$this->_conn->affected_rows;}}function
connect(){global$b;$g=new
Min_DB;$j=$b->credentials();if($g->connect($j[0],$j[1],$j[2]))return$g;return$g->error;}function
support($Pc){return
preg_match("~database|table|columns~",$Pc);}function
logged_user(){global$b;$j=$b->credentials();return$j[1];}function
get_databases(){global$g;$I=$g->rootQuery('_aliases');if($I){$I=array_keys($I);sort($I,SORT_STRING);}return$I;}function
collations(){return
array();}function
db_collation($m,$qb){}function
engines(){return
array();}function
count_tables($l){global$g;$I=array();$H=$g->query('_stats');if($H&&$H['indices']){$Hd=$H['indices'];foreach($Hd
as$Gd=>$wh){$Fd=$wh['total']['indexing'];$I[$Gd]=$Fd['index_total'];}}return$I;}function
tables_list(){global$g;$I=$g->query('_mapping');if($I)$I=array_fill_keys(array_keys($I[$g->_db]["mappings"]),'table');return$I;}function
table_status($C="",$Oc=false){global$g;$Vg=$g->query("_search",array("size"=>0,"aggregations"=>array("count_by_type"=>array("terms"=>array("field"=>"_type")))),"POST");$I=array();if($Vg){$T=$Vg["aggregations"]["count_by_type"]["buckets"];foreach($T
as$R){$I[$R["key"]]=array("Name"=>$R["key"],"Engine"=>"table","Rows"=>$R["doc_count"],);if($C!=""&&$C==$R["key"])return$I[$C];}}return$I;}function
error(){global$g;return
h($g->error);}function
information_schema(){}function
is_view($S){}function
indexes($R,$h=null){return
array(array("type"=>"PRIMARY","columns"=>array("_id")),);}function
fields($R){global$g;$H=$g->query("$R/_mapping");$I=array();if($H){$we=$H[$R]['properties'];if(!$we)$we=$H[$g->_db]['mappings'][$R]['properties'];if($we){foreach($we
as$C=>$p){$I[$C]=array("field"=>$C,"full_type"=>$p["type"],"type"=>$p["type"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);if($p["properties"]){unset($I[$C]["privileges"]["insert"]);unset($I[$C]["privileges"]["update"]);}}}}return$I;}function
foreign_keys($R){return
array();}function
table($v){return$v;}function
idf_escape($v){return$v;}function
convert_field($p){}function
unconvert_field($p,$I){return$I;}function
fk_support($S){}function
found_rows($S,$Z){return
null;}function
create_database($m){global$g;return$g->rootQuery(urlencode($m),null,'PUT');}function
drop_databases($l){global$g;return$g->rootQuery(urlencode(implode(',',$l)),array(),'DELETE');}function
alter_table($R,$C,$q,$bd,$vb,$uc,$pb,$Ma,$Nf){global$g;$lg=array();foreach($q
as$Mc){$Rc=trim($Mc[1][0]);$Sc=trim($Mc[1][1]?$Mc[1][1]:"text");$lg[$Rc]=array('type'=>$Sc);}if(!empty($lg))$lg=array('properties'=>$lg);return$g->query("_mapping/{$C}",$lg,'PUT');}function
drop_tables($T){global$g;$I=true;foreach($T
as$R)$I=$I&&$g->query(urlencode($R),array(),'DELETE');return$I;}function
last_id(){global$g;return$g->last_id;}$y="elastic";$pf=array("=","query");$jd=array();$pd=array();$mc=array(array("json"));$ui=array();$zh=array();foreach(array(lang(25)=>array("long"=>3,"integer"=>5,"short"=>8,"byte"=>10,"double"=>20,"float"=>66,"half_float"=>12,"scaled_float"=>21),lang(26)=>array("date"=>10),lang(23)=>array("string"=>65535,"text"=>65535),lang(27)=>array("binary"=>255),)as$z=>$X){$ui+=$X;$zh[$z]=array_keys($X);}}$ec=array("server"=>"MySQL")+$ec;if(!defined("DRIVER")){$ag=array("MySQLi","MySQL","PDO_MySQL");define("DRIVER","server");if(extension_loaded("mysqli")){class
Min_DB
extends
MySQLi{var$extension="MySQLi";function
__construct(){parent::init();}function
connect($N="",$V="",$F="",$k=null,$Wf=null,$lh=null){global$b;mysqli_report(MYSQLI_REPORT_OFF);list($yd,$Wf)=explode(":",$N,2);$uh=$b->connectSsl();if($uh)$this->ssl_set($uh['key'],$uh['cert'],$uh['ca'],'','');$I=@$this->real_connect(($N!=""?$yd:ini_get("mysqli.default_host")),($N.$V!=""?$V:ini_get("mysqli.default_user")),($N.$V.$F!=""?$F:ini_get("mysqli.default_pw")),$k,(is_numeric($Wf)?$Wf:ini_get("mysqli.default_port")),(!is_numeric($Wf)?$Wf:$lh),($uh?64:0));return$I;}function
set_charset($cb){if(parent::set_charset($cb))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $cb");}function
result($G,$p=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch_array();return$J[$p];}function
quote($Q){return"'".$this->escape_string($Q)."'";}}}elseif(extension_loaded("mysql")&&!(ini_get("sql.safe_mode")&&extension_loaded("pdo_mysql"))){class
Min_DB{var$extension="MySQL",$server_info,$affected_rows,$errno,$error,$_link,$_result;function
connect($N,$V,$F){$this->_link=@mysql_connect(($N!=""?$N:ini_get("mysql.default_host")),("$N$V"!=""?$V:ini_get("mysql.default_user")),("$N$V$F"!=""?$F:ini_get("mysql.default_password")),true,131072);if($this->_link)$this->server_info=mysql_get_server_info($this->_link);else$this->error=mysql_error();return(bool)$this->_link;}function
set_charset($cb){if(function_exists('mysql_set_charset')){if(mysql_set_charset($cb,$this->_link))return
true;mysql_set_charset('utf8',$this->_link);}return$this->query("SET NAMES $cb");}function
quote($Q){return"'".mysql_real_escape_string($Q,$this->_link)."'";}function
select_db($k){return
mysql_select_db($k,$this->_link);}function
query($G,$vi=false){$H=@($vi?mysql_unbuffered_query($G,$this->_link):mysql_query($G,$this->_link));$this->error="";if(!$H){$this->errno=mysql_errno($this->_link);$this->error=mysql_error($this->_link);return
false;}if($H===true){$this->affected_rows=mysql_affected_rows($this->_link);$this->info=mysql_info($this->_link);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$p=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;return
mysql_result($H->_result,0,$p);}}class
Min_Result{var$num_rows,$_result,$_offset=0;function
__construct($H){$this->_result=$H;$this->num_rows=mysql_num_rows($H);}function
fetch_assoc(){return
mysql_fetch_assoc($this->_result);}function
fetch_row(){return
mysql_fetch_row($this->_result);}function
fetch_field(){$I=mysql_fetch_field($this->_result,$this->_offset++);$I->orgtable=$I->table;$I->orgname=$I->name;$I->charsetnr=($I->blob?63:0);return$I;}function
__destruct(){mysql_free_result($this->_result);}}}elseif(extension_loaded("pdo_mysql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_MySQL";function
connect($N,$V,$F){global$b;$sf=array();$uh=$b->connectSsl();if($uh)$sf=array(PDO::MYSQL_ATTR_SSL_KEY=>$uh['key'],PDO::MYSQL_ATTR_SSL_CERT=>$uh['cert'],PDO::MYSQL_ATTR_SSL_CA=>$uh['ca'],);$this->dsn("mysql:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\\d)~',';port=\\1',$N)),$V,$F,$sf);return
true;}function
set_charset($cb){$this->query("SET NAMES $cb");}function
select_db($k){return$this->query("USE ".idf_escape($k));}function
query($G,$vi=false){$this->setAttribute(1000,!$vi);return
parent::query($G,$vi);}}}class
Min_Driver
extends
Min_SQL{function
insert($R,$O){return($O?parent::insert($R,$O):queries("INSERT INTO ".table($R)." ()\nVALUES ()"));}function
insertUpdate($R,$K,$dg){$e=array_keys(reset($K));$bg="INSERT INTO ".table($R)." (".implode(", ",$e).") VALUES\n";$Mi=array();foreach($e
as$z)$Mi[$z]="$z = VALUES($z)";$Bh="\nON DUPLICATE KEY UPDATE ".implode(", ",$Mi);$Mi=array();$pe=0;foreach($K
as$O){$Y="(".implode(", ",$O).")";if($Mi&&(strlen($bg)+$pe+strlen($Y)+strlen($Bh)>1e6)){if(!queries($bg.implode(",\n",$Mi).$Bh))return
false;$Mi=array();$pe=0;}$Mi[]=$Y;$pe+=strlen($Y)+2;}return
queries($bg.implode(",\n",$Mi).$Bh);}function
convertSearch($v,$X,$p){return(preg_match('~char|text|enum|set~',$p["type"])&&!preg_match("~^utf8~",$p["collation"])?"CONVERT($v USING ".charset($this->_conn).")":$v);}function
warnings(){$H=$this->_conn->query("SHOW WARNINGS");if($H&&$H->num_rows){ob_start();select($H);return
ob_get_clean();}}function
tableHelp($C){$xe=preg_match('~MariaDB~',$this->_conn->server_info);if(information_schema(DB))return
strtolower(($xe?"information-schema-$C-table/":str_replace("_","-",$C)."-table.html"));if(DB=="mysql")return($xe?"mysql$C-table/":"system-database.html");}}function
idf_escape($v){return"`".str_replace("`","``",$v)."`";}function
table($v){return
idf_escape($v);}function
connect(){global$b,$ui,$zh;$g=new
Min_DB;$j=$b->credentials();if($g->connect($j[0],$j[1],$j[2])){$g->set_charset(charset($g));$g->query("SET sql_quote_show_create = 1, autocommit = 1");if(min_version('5.7.8',10.2,$g)){$zh[lang(23)][]="json";$ui["json"]=4294967295;}return$g;}$I=$g->error;if(function_exists('iconv')&&!is_utf8($I)&&strlen($Rg=iconv("windows-1250","utf-8",$I))>strlen($I))$I=$Rg;return$I;}function
get_databases($ad){$I=get_session("dbs");if($I===null){$G=(min_version(5)?"SELECT SCHEMA_NAME FROM information_schema.SCHEMATA":"SHOW DATABASES");$I=($ad?slow_query($G):get_vals($G));restart_session();set_session("dbs",$I);stop_session();}return$I;}function
limit($G,$Z,$_,$D=0,$M=" "){return" $G$Z".($_!==null?$M."LIMIT $_".($D?" OFFSET $D":""):"");}function
limit1($R,$G,$Z,$M="\n"){return
limit($G,$Z,1,0,$M);}function
db_collation($m,$qb){global$g;$I=null;$i=$g->result("SHOW CREATE DATABASE ".idf_escape($m),1);if(preg_match('~ COLLATE ([^ ]+)~',$i,$B))$I=$B[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$i,$B))$I=$qb[$B[1]][-1];return$I;}function
engines(){$I=array();foreach(get_rows("SHOW ENGINES")as$J){if(preg_match("~YES|DEFAULT~",$J["Support"]))$I[]=$J["Engine"];}return$I;}function
logged_user(){global$g;return$g->result("SELECT USER()");}function
tables_list(){return
get_key_vals(min_version(5)?"SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME":"SHOW TABLES");}function
count_tables($l){$I=array();foreach($l
as$m)$I[$m]=count(get_vals("SHOW TABLES IN ".idf_escape($m)));return$I;}function
table_status($C="",$Oc=false){$I=array();foreach(get_rows($Oc&&min_version(5)?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($C!=""?"AND TABLE_NAME = ".q($C):"ORDER BY Name"):"SHOW TABLE STATUS".($C!=""?" LIKE ".q(addcslashes($C,"%_\\")):""))as$J){if($J["Engine"]=="InnoDB")$J["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\\1',$J["Comment"]);if(!isset($J["Engine"]))$J["Comment"]="";if($C!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($S){return$S["Engine"]===null;}function
fk_support($S){return
preg_match('~InnoDB|IBMDB2I~i',$S["Engine"])||(preg_match('~NDB~i',$S["Engine"])&&min_version(5.6));}function
fields($R){$I=array();foreach(get_rows("SHOW FULL COLUMNS FROM ".table($R))as$J){preg_match('~^([^( ]+)(?:\\((.+)\\))?( unsigned)?( zerofill)?$~',$J["Type"],$B);$I[$J["Field"]]=array("field"=>$J["Field"],"full_type"=>$J["Type"],"type"=>$B[1],"length"=>$B[2],"unsigned"=>ltrim($B[3].$B[4]),"default"=>($J["Default"]!=""||preg_match("~char|set~",$B[1])?$J["Default"]:null),"null"=>($J["Null"]=="YES"),"auto_increment"=>($J["Extra"]=="auto_increment"),"on_update"=>(preg_match('~^on update (.+)~i',$J["Extra"],$B)?$B[1]:""),"collation"=>$J["Collation"],"privileges"=>array_flip(preg_split('~, *~',$J["Privileges"])),"comment"=>$J["Comment"],"primary"=>($J["Key"]=="PRI"),);}return$I;}function
indexes($R,$h=null){$I=array();foreach(get_rows("SHOW INDEX FROM ".table($R),$h)as$J){$C=$J["Key_name"];$I[$C]["type"]=($C=="PRIMARY"?"PRIMARY":($J["Index_type"]=="FULLTEXT"?"FULLTEXT":($J["Non_unique"]?($J["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$I[$C]["columns"][]=$J["Column_name"];$I[$C]["lengths"][]=($J["Index_type"]=="SPATIAL"?null:$J["Sub_part"]);$I[$C]["descs"][]=null;}return$I;}function
foreign_keys($R){global$g,$kf;static$Tf='`(?:[^`]|``)+`';$I=array();$Fb=$g->result("SHOW CREATE TABLE ".table($R),1);if($Fb){preg_match_all("~CONSTRAINT ($Tf) FOREIGN KEY ?\\(((?:$Tf,? ?)+)\\) REFERENCES ($Tf)(?:\\.($Tf))? \\(((?:$Tf,? ?)+)\\)(?: ON DELETE ($kf))?(?: ON UPDATE ($kf))?~",$Fb,$_e,PREG_SET_ORDER);foreach($_e
as$B){preg_match_all("~$Tf~",$B[2],$nh);preg_match_all("~$Tf~",$B[5],$Oh);$I[idf_unescape($B[1])]=array("db"=>idf_unescape($B[4]!=""?$B[3]:$B[4]),"table"=>idf_unescape($B[4]!=""?$B[4]:$B[3]),"source"=>array_map('idf_unescape',$nh[0]),"target"=>array_map('idf_unescape',$Oh[0]),"on_delete"=>($B[6]?$B[6]:"RESTRICT"),"on_update"=>($B[7]?$B[7]:"RESTRICT"),);}}return$I;}function
view($C){global$g;return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\\s+AS\\s+~isU','',$g->result("SHOW CREATE VIEW ".table($C),1)));}function
collations(){$I=array();foreach(get_rows("SHOW COLLATION")as$J){if($J["Default"])$I[$J["Charset"]][-1]=$J["Collation"];else$I[$J["Charset"]][]=$J["Collation"];}ksort($I);foreach($I
as$z=>$X)asort($I[$z]);return$I;}function
information_schema($m){return(min_version(5)&&$m=="information_schema")||(min_version(5.5)&&$m=="performance_schema");}function
error(){global$g;return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",$g->error));}function
create_database($m,$pb){return
queries("CREATE DATABASE ".idf_escape($m).($pb?" COLLATE ".q($pb):""));}function
drop_databases($l){$I=apply_queries("DROP DATABASE",$l,'idf_escape');restart_session();set_session("dbs",null);return$I;}function
rename_database($C,$pb){$I=false;if(create_database($C,$pb)){$Dg=array();foreach(tables_list()as$R=>$U)$Dg[]=table($R)." TO ".idf_escape($C).".".table($R);$I=(!$Dg||queries("RENAME TABLE ".implode(", ",$Dg)));if($I)queries("DROP DATABASE ".idf_escape(DB));restart_session();set_session("dbs",null);}return$I;}function
auto_increment(){$Na=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$w){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$w["columns"],true)){$Na="";break;}if($w["type"]=="PRIMARY")$Na=" UNIQUE";}}return" AUTO_INCREMENT$Na";}function
alter_table($R,$C,$q,$bd,$vb,$uc,$pb,$Ma,$Nf){$c=array();foreach($q
as$p)$c[]=($p[1]?($R!=""?($p[0]!=""?"CHANGE ".idf_escape($p[0]):"ADD"):" ")." ".implode($p[1]).($R!=""?$p[2]:""):"DROP ".idf_escape($p[0]));$c=array_merge($c,$bd);$P=($vb!==null?" COMMENT=".q($vb):"").($uc?" ENGINE=".q($uc):"").($pb?" COLLATE ".q($pb):"").($Ma!=""?" AUTO_INCREMENT=$Ma":"");if($R=="")return
queries("CREATE TABLE ".table($C)." (\n".implode(",\n",$c)."\n)$P$Nf");if($R!=$C)$c[]="RENAME TO ".table($C);if($P)$c[]=ltrim($P);return($c||$Nf?queries("ALTER TABLE ".table($R)."\n".implode(",\n",$c).$Nf):true);}function
alter_indexes($R,$c){foreach($c
as$z=>$X)$c[$z]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($R).implode(",",$c));}function
truncate_tables($T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views($Ri){return
queries("DROP VIEW ".implode(", ",array_map('table',$Ri)));}function
drop_tables($T){return
queries("DROP TABLE ".implode(", ",array_map('table',$T)));}function
move_tables($T,$Ri,$Oh){$Dg=array();foreach(array_merge($T,$Ri)as$R)$Dg[]=table($R)." TO ".idf_escape($Oh).".".table($R);return
queries("RENAME TABLE ".implode(", ",$Dg));}function
copy_tables($T,$Ri,$Oh){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($T
as$R){$C=($Oh==DB?table("copy_$R"):idf_escape($Oh).".".table($R));if(!queries("\nDROP TABLE IF EXISTS $C")||!queries("CREATE TABLE $C LIKE ".table($R))||!queries("INSERT INTO $C SELECT * FROM ".table($R)))return
false;}foreach($Ri
as$R){$C=($Oh==DB?table("copy_$R"):idf_escape($Oh).".".table($R));$Qi=view($R);if(!queries("DROP VIEW IF EXISTS $C")||!queries("CREATE VIEW $C AS $Qi[select]"))return
false;}return
true;}function
trigger($C){if($C=="")return
array();$K=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($C));return
reset($K);}function
triggers($R){$I=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($R,"%_\\")))as$J)$I[$J["Trigger"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($C,$U){global$g,$wc,$Md,$ui;$Da=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");$oh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$ti="((".implode("|",array_merge(array_keys($ui),$Da)).")\\b(?:\\s*\\(((?:[^'\")]|$wc)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";$Tf="$oh*(".($U=="FUNCTION"?"":$Md).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$ti";$i=$g->result("SHOW CREATE $U ".idf_escape($C),2);preg_match("~\\(((?:$Tf\\s*,?)*)\\)\\s*".($U=="FUNCTION"?"RETURNS\\s+$ti\\s+":"")."(.*)~is",$i,$B);$q=array();preg_match_all("~$Tf\\s*,?~is",$B[1],$_e,PREG_SET_ORDER);foreach($_e
as$Gf){$C=str_replace("``","`",$Gf[2]).$Gf[3];$q[]=array("field"=>$C,"type"=>strtolower($Gf[5]),"length"=>preg_replace_callback("~$wc~s",'normalize_enum',$Gf[6]),"unsigned"=>strtolower(preg_replace('~\\s+~',' ',trim("$Gf[8] $Gf[7]"))),"null"=>1,"full_type"=>$Gf[4],"inout"=>strtoupper($Gf[1]),"collation"=>strtolower($Gf[9]),);}if($U!="FUNCTION")return
array("fields"=>$q,"definition"=>$B[11]);return
array("fields"=>$q,"returns"=>array("type"=>$B[12],"length"=>$B[13],"unsigned"=>$B[15],"collation"=>$B[16]),"definition"=>$B[17],"language"=>"SQL",);}function
routines(){return
get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = ".q(DB));}function
routine_languages(){return
array();}function
routine_id($C,$J){return
idf_escape($C);}function
last_id(){global$g;return$g->result("SELECT LAST_INSERT_ID()");}function
explain($g,$G){return$g->query("EXPLAIN ".(min_version(5.1)?"PARTITIONS ":"").$G);}function
found_rows($S,$Z){return($Z||$S["Engine"]!="InnoDB"?null:$S["Rows"]);}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Tg){return
true;}function
create_sql($R,$Ma,$_h){global$g;$I=$g->result("SHOW CREATE TABLE ".table($R),1);if(!$Ma)$I=preg_replace('~ AUTO_INCREMENT=\\d+~','',$I);return$I;}function
truncate_sql($R){return"TRUNCATE ".table($R);}function
use_sql($k){return"USE ".idf_escape($k);}function
trigger_sql($R){$I="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($R,"%_\\")),null,"-- ")as$J)$I.="\nCREATE TRIGGER ".idf_escape($J["Trigger"])." $J[Timing] $J[Event] ON ".table($J["Table"])." FOR EACH ROW\n$J[Statement];;\n";return$I;}function
show_variables(){return
get_key_vals("SHOW VARIABLES");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
show_status(){return
get_key_vals("SHOW STATUS");}function
convert_field($p){if(preg_match("~binary~",$p["type"]))return"HEX(".idf_escape($p["field"]).")";if($p["type"]=="bit")return"BIN(".idf_escape($p["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$p["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($p["field"]).")";}function
unconvert_field($p,$I){if(preg_match("~binary~",$p["type"]))$I="UNHEX($I)";if($p["type"]=="bit")$I="CONV($I, 2, 10) + 0";if(preg_match("~geometry|point|linestring|polygon~",$p["type"]))$I=(min_version(8)?"ST_":"")."GeomFromText($I)";return$I;}function
support($Pc){return!preg_match("~scheme|sequence|type|view_trigger|materializedview".(min_version(5.1)?"":"|event|partitioning".(min_version(5)?"":"|routine|trigger|view"))."~",$Pc);}function
kill_process($X){return
queries("KILL ".number($X));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){global$g;return$g->result("SELECT @@max_connections");}$y="sql";$ui=array();$zh=array();foreach(array(lang(25)=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),lang(26)=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),lang(23)=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),lang(30)=>array("enum"=>65535,"set"=>64),lang(27)=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),lang(29)=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),)as$z=>$X){$ui+=$X;$zh[$z]=array_keys($X);}$Ai=array("unsigned","zerofill","unsigned zerofill");$pf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");$jd=array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper");$pd=array("avg","count","count distinct","group_concat","max","min","sum");$mc=array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",));}define("SERVER",$_GET[DRIVER]);define("DB",$_GET["db"]);define("ME",preg_replace('~^[^?]*/([^?]*).*~','\\1',$_SERVER["REQUEST_URI"]).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));$ia="4.6.1";class
Adminer{var$operators;function
name(){return"<a href='https://www.adminer.org/'".target_blank()." id='h1'>Adminer</a>";}function
credentials(){return
array(SERVER,$_GET["username"],get_password());}function
connectSsl(){}function
permanentLogin($i=false){return
password_file($i);}function
bruteForceKey(){return$_SERVER["REMOTE_ADDR"];}function
serverName($N){return
h($N);}function
database(){return
DB;}function
databases($ad=true){return
get_databases($ad);}function
schemas(){return
schemas();}function
queryTimeout(){return
5;}function
headers(){}function
csp(){return
csp();}function
head(){return
true;}function
css(){$I=array();$Uc="adminer.css";if(file_exists($Uc))$I[]=$Uc;return$I;}function
loginForm(){global$ec;echo'<table cellspacing="0">
<tr><th>',lang(31),'<td>',html_select("auth[driver]",$ec,DRIVER)."\n",'<tr><th>',lang(32),'<td><input name="auth[server]" value="',h(SERVER),'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">
<tr><th>',lang(33),'<td><input name="auth[username]" id="username" value="',h($_GET["username"]),'" autocapitalize="off">
<tr><th>',lang(34),'<td><input type="password" name="auth[password]">
<tr><th>',lang(35),'<td><input name="auth[db]" value="',h($_GET["db"]),'" autocapitalize="off">
</table>
',script("focus(qs('#username'));"),"<p><input type='submit' value='".lang(36)."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],lang(37))."\n";}function
login($ue,$F){global$y;if($y=="sqlite")return
lang(38,target_blank(),'<code>login()</code>');return
true;}function
tableName($Fh){return
h($Fh["Name"]);}function
fieldName($p,$uf=0){return'<span title="'.h($p["full_type"]).'">'.h($p["field"]).'</span>';}function
selectLinks($Fh,$O=""){global$y,$n;echo'<p class="links">';$se=array("select"=>lang(39));if(support("table")||support("indexes"))$se["table"]=lang(40);if(support("table")){if(is_view($Fh))$se["view"]=lang(41);else$se["create"]=lang(42);}if($O!==null)$se["edit"]=lang(43);$C=$Fh["Name"];foreach($se
as$z=>$X)echo" <a href='".h(ME)."$z=".urlencode($C).($z=="edit"?$O:"")."'".bold(isset($_GET[$z])).">$X</a>";echo
doc_link(array($y=>$n->tableHelp($C)),"?"),"\n";}function
foreignKeys($R){return
foreign_keys($R);}function
backwardKeys($R,$Eh){return
array();}function
backwardKeysPrint($Pa,$J){}function
selectQuery($G,$vh,$Nc=false){global$y,$n;$I="</p>\n";if(!$Nc&&($Ui=$n->warnings())){$u="warnings";$I=", <a href='#$u'>".lang(44)."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."$I<div id='$u' class='hidden'>\n$Ui</div>\n";}return"<p><code class='jush-$y'>".h(str_replace("\n"," ",$G))."</code> <span class='time'>(".format_time($vh).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($G)."'>".lang(10)."</a>":"").$I;}function
sqlCommandQuery($G){return
shorten_utf8(trim($G),1000);}function
rowDescription($R){return"";}function
rowDescriptions($K,$cd){return$K;}function
selectLink($X,$p){}function
selectVal($X,$A,$p,$Bf){$I=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$p["type"])&&!preg_match("~var~",$p["type"])?"<code>$X</code>":$X));if(preg_match('~blob|bytea|raw|file~',$p["type"])&&!is_utf8($X))$I="<i>".lang(45,strlen($Bf))."</i>";if(preg_match('~json~',$p["type"]))$I="<code class='jush-js'>$I</code>";return($A?"<a href='".h($A)."'".(is_url($A)?target_blank():"").">$I</a>":$I);}function
editVal($X,$p){return$X;}function
tableStructurePrint($q){echo"<table cellspacing='0' class='nowrap'>\n","<thead><tr><th>".lang(46)."<td>".lang(47).(support("comment")?"<td>".lang(48):"")."</thead>\n";foreach($q
as$p){echo"<tr".odd()."><th>".h($p["field"]),"<td><span title='".h($p["collation"])."'>".h($p["full_type"])."</span>",($p["null"]?" <i>NULL</i>":""),($p["auto_increment"]?" <i>".lang(49)."</i>":""),(isset($p["default"])?" <span title='".lang(50)."'>[<b>".h($p["default"])."</b>]</span>":""),(support("comment")?"<td>".nbsp($p["comment"]):""),"\n";}echo"</table>\n";}function
tableIndexesPrint($x){echo"<table cellspacing='0'>\n";foreach($x
as$C=>$w){ksort($w["columns"]);$fg=array();foreach($w["columns"]as$z=>$X)$fg[]="<i>".h($X)."</i>".($w["lengths"][$z]?"(".$w["lengths"][$z].")":"").($w["descs"][$z]?" DESC":"");echo"<tr title='".h($C)."'><th>$w[type]<td>".implode(", ",$fg)."\n";}echo"</table>\n";}function
selectColumnsPrint($L,$e){global$jd,$pd;print_fieldset("select",lang(51),$L);$t=0;$L[""]=array();foreach($L
as$z=>$X){$X=$_GET["columns"][$z];$d=select_input(" name='columns[$t][col]'",$e,$X["col"],($z!==""?"selectFieldChange":"selectAddRow"));echo"<div>".($jd||$pd?"<select name='columns[$t][fun]'>".optionlist(array(-1=>"")+array_filter(array(lang(52)=>$jd,lang(53)=>$pd)),$X["fun"])."</select>".on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($z!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($d)":$d)."</div>\n";$t++;}echo"</div></fieldset>\n";}function
selectSearchPrint($Z,$e,$x){print_fieldset("search",lang(54),$Z);foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT"){echo"<div>(<i>".implode("</i>, <i>",array_map('h',$w["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$t]' value='".h($_GET["fulltext"][$t])."'>",script("qsl('input').oninput = selectFieldChange;",""),checkbox("boolean[$t]",1,isset($_GET["boolean"][$t]),"BOOL"),"</div>\n";}}$bb="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$t=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators))){echo"<div>".select_input(" name='where[$t][col]'",$e,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".lang(55).")"),html_select("where[$t][op]",$this->operators,$X["op"],$bb),"<input type='search' name='where[$t][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $bb }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}}echo"</div></fieldset>\n";}function
selectOrderPrint($uf,$e,$x){print_fieldset("sort",lang(56),$uf);$t=0;foreach((array)$_GET["order"]as$z=>$X){if($X!=""){echo"<div>".select_input(" name='order[$t]'",$e,$X,"selectFieldChange"),checkbox("desc[$t]",1,isset($_GET["desc"][$z]),lang(57))."</div>\n";$t++;}}echo"<div>".select_input(" name='order[$t]'",$e,"","selectAddRow"),checkbox("desc[$t]",1,false,lang(57))."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($_){echo"<fieldset><legend>".lang(58)."</legend><div>";echo"<input type='number' name='limit' class='size' value='".h($_)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($Uh){if($Uh!==null){echo"<fieldset><legend>".lang(59)."</legend><div>","<input type='number' name='text_length' class='size' value='".h($Uh)."'>","</div></fieldset>\n";}}function
selectActionPrint($x){echo"<fieldset><legend>".lang(60)."</legend><div>","<input type='submit' value='".lang(51)."'>"," <span id='noindex' title='".lang(61)."'></span>","<script".nonce().">\n","var indexColumns = ";$e=array();foreach($x
as$w){$Kb=reset($w["columns"]);if($w["type"]!="FULLTEXT"&&$Kb)$e[$Kb]=1;}$e[""]=1;foreach($e
as$z=>$X)json_row($z);echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";}function
selectCommandPrint(){return!information_schema(DB);}function
selectImportPrint(){return!information_schema(DB);}function
selectEmailPrint($rc,$e){}function
selectColumnsProcess($e,$x){global$jd,$pd;$L=array();$md=array();foreach((array)$_GET["columns"]as$z=>$X){if($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"],$jd)||in_array($X["fun"],$pd)))){$L[$z]=apply_sql_function($X["fun"],($X["col"]!=""?idf_escape($X["col"]):"*"));if(!in_array($X["fun"],$pd))$md[]=$L[$z];}}return
array($L,$md);}function
selectSearchProcess($q,$x){global$g,$n;$I=array();foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT"&&$_GET["fulltext"][$t]!="")$I[]="MATCH (".implode(", ",array_map('idf_escape',$w["columns"])).") AGAINST (".q($_GET["fulltext"][$t]).(isset($_GET["boolean"][$t])?" IN BOOLEAN MODE":"").")";}foreach((array)$_GET["where"]as$z=>$X){if("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)){$bg="";$xb=" $X[op]";if(preg_match('~IN$~',$X["op"])){$Cd=process_length($X["val"]);$xb.=" ".($Cd!=""?$Cd:"(NULL)");}elseif($X["op"]=="SQL")$xb=" $X[val]";elseif($X["op"]=="LIKE %%")$xb=" LIKE ".$this->processInput($q[$X["col"]],"%$X[val]%");elseif($X["op"]=="ILIKE %%")$xb=" ILIKE ".$this->processInput($q[$X["col"]],"%$X[val]%");elseif($X["op"]=="FIND_IN_SET"){$bg="$X[op](".q($X["val"]).", ";$xb=")";}elseif(!preg_match('~NULL$~',$X["op"]))$xb.=" ".$this->processInput($q[$X["col"]],$X["val"]);if($X["col"]!="")$I[]=$bg.$n->convertSearch(idf_escape($X["col"]),$X,$q[$X["col"]]).$xb;else{$sb=array();foreach($q
as$C=>$p){if((is_numeric($X["val"])||!preg_match('~'.number_type().'|bit~',$p["type"]))&&(!preg_match("~[\x80-\xFF]~",$X["val"])||preg_match('~char|text|enum|set~',$p["type"])))$sb[]=$bg.$n->convertSearch(idf_escape($C),$X,$p).$xb;}$I[]=($sb?"(".implode(" OR ",$sb).")":"1 = 0");}}}return$I;}function
selectOrderProcess($q,$x){$I=array();foreach((array)$_GET["order"]as$z=>$X){if($X!="")$I[]=(preg_match('~^((COUNT\\(DISTINCT |[A-Z0-9_]+\\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\\)|COUNT\\(\\*\\))$~',$X)?$X:idf_escape($X)).(isset($_GET["desc"][$z])?" DESC":"");}return$I;}function
selectLimitProcess(){return(isset($_GET["limit"])?$_GET["limit"]:"50");}function
selectLengthProcess(){return(isset($_GET["text_length"])?$_GET["text_length"]:"100");}function
selectEmailProcess($Z,$cd){return
false;}function
selectQueryBuild($L,$Z,$md,$uf,$_,$E){return"";}function
messageQuery($G,$Vh,$Nc=false){global$y,$n;restart_session();$vd=&get_session("queries");if(!$vd[$_GET["db"]])$vd[$_GET["db"]]=array();if(strlen($G)>1e6)$G=preg_replace('~[\x80-\xFF]+$~','',substr($G,0,1e6))."\n...";$vd[$_GET["db"]][]=array($G,time(),$Vh);$sh="sql-".count($vd[$_GET["db"]]);$I="<a href='#$sh' class='toggle'>".lang(62)."</a>\n";if(!$Nc&&($Ui=$n->warnings())){$u="warnings-".count($vd[$_GET["db"]]);$I="<a href='#$u' class='toggle'>".lang(44)."</a>, $I<div id='$u' class='hidden'>\n$Ui</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $I<div id='$sh' class='hidden'><pre><code class='jush-$y'>".shorten_utf8($G,1000)."</code></pre>".($Vh?" <span class='time'>($Vh)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($vd[$_GET["db"]])-1)).'">'.lang(10).'</a>':'').'</div>';}function
editFunctions($p){global$mc;$I=($p["null"]?"NULL/":"");foreach($mc
as$z=>$jd){if(!$z||(!isset($_GET["call"])&&(isset($_GET["select"])||where($_GET)))){foreach($jd
as$Tf=>$X){if(!$Tf||preg_match("~$Tf~",$p["type"]))$I.="/$X";}if($z&&!preg_match('~set|blob|bytea|raw|file~',$p["type"]))$I.="/SQL";}}if($p["auto_increment"]&&!isset($_GET["select"])&&!where($_GET))$I=lang(49);return
explode("/",$I);}function
editInput($R,$p,$Ka,$Y){if($p["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$Ka value='-1' checked><i>".lang(8)."</i></label> ":"").($p["null"]?"<label><input type='radio'$Ka value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio",$Ka,$p,$Y,0);return"";}function
editHint($R,$p,$Y){return"";}function
processInput($p,$Y,$s=""){if($s=="SQL")return$Y;$C=$p["field"];$I=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$s))$I="$s()";elseif(preg_match('~^current_(date|timestamp)$~',$s))$I=$s;elseif(preg_match('~^([+-]|\\|\\|)$~',$s))$I=idf_escape($C)." $s $I";elseif(preg_match('~^[+-] interval$~',$s))$I=idf_escape($C)." $s ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)?$Y:$I);elseif(preg_match('~^(addtime|subtime|concat)$~',$s))$I="$s(".idf_escape($C).", $I)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$s))$I="$s($I)";return
unconvert_field($p,$I);}function
dumpOutput(){$I=array('text'=>lang(63),'file'=>lang(64));if(function_exists('gzencode'))$I['gz']='gzip';return$I;}function
dumpFormat(){return
array('sql'=>'SQL','csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($m){}function
dumpTable($R,$_h,$Vd=0){if($_POST["format"]!="sql"){echo"\xef\xbb\xbf";if($_h)dump_csv(array_keys(fields($R)));}else{if($Vd==2){$q=array();foreach(fields($R)as$C=>$p)$q[]=idf_escape($C)." $p[full_type]";$i="CREATE TABLE ".table($R)." (".implode(", ",$q).")";}else$i=create_sql($R,$_POST["auto_increment"],$_h);set_utf8mb4($i);if($_h&&$i){if($_h=="DROP+CREATE"||$Vd==1)echo"DROP ".($Vd==2?"VIEW":"TABLE")." IF EXISTS ".table($R).";\n";if($Vd==1)$i=remove_definer($i);echo"$i;\n\n";}}}function
dumpData($R,$_h,$G){global$g,$y;$Be=($y=="sqlite"?0:1048576);if($_h){if($_POST["format"]=="sql"){if($_h=="TRUNCATE+INSERT")echo
truncate_sql($R).";\n";$q=fields($R);}$H=$g->query($G,1);if($H){$Od="";$Ya="";$ce=array();$Bh="";$Qc=($R!=''?'fetch_assoc':'fetch_row');while($J=$H->$Qc()){if(!$ce){$Mi=array();foreach($J
as$X){$p=$H->fetch_field();$ce[]=$p->name;$z=idf_escape($p->name);$Mi[]="$z = VALUES($z)";}$Bh=($_h=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ",$Mi):"").";\n";}if($_POST["format"]!="sql"){if($_h=="table"){dump_csv($ce);$_h="INSERT";}dump_csv($J);}else{if(!$Od)$Od="INSERT INTO ".table($R)." (".implode(", ",array_map('idf_escape',$ce)).") VALUES";foreach($J
as$z=>$X){$p=$q[$z];$J[$z]=($X!==null?unconvert_field($p,preg_match(number_type(),$p["type"])&&$X!=''?$X:q($X)):"NULL");}$Rg=($Be?"\n":" ")."(".implode(",\t",$J).")";if(!$Ya)$Ya=$Od.$Rg;elseif(strlen($Ya)+4+strlen($Rg)+strlen($Bh)<$Be)$Ya.=",$Rg";else{echo$Ya.$Bh;$Ya=$Od.$Rg;}}}if($Ya)echo$Ya.$Bh;}elseif($_POST["format"]=="sql")echo"-- ".str_replace("\n"," ",$g->error)."\n";}}function
dumpFilename($_d){return
friendly_url($_d!=""?$_d:(SERVER!=""?SERVER:"localhost"));}function
dumpHeaders($_d,$Qe=false){$Ef=$_POST["output"];$Ic=(preg_match('~sql~',$_POST["format"])?"sql":($Qe?"tar":"csv"));header("Content-Type: ".($Ef=="gz"?"application/x-gzip":($Ic=="tar"?"application/x-tar":($Ic=="sql"||$Ef!="file"?"text/plain":"text/csv")."; charset=utf-8")));if($Ef=="gz")ob_start('ob_gzencode',1e6);return$Ic;}function
importServerPath(){return"adminer.sql";}function
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.lang(65)."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?lang(66):lang(67))."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.lang(68)."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".lang(69)."</a>\n":"");return
true;}function
navigation($Pe){global$ia,$y,$ec,$g;echo'<h1>
',$this->name(),' <span class="version">',$ia,'</span>
<a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ia,$_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</h1>
';if($Pe=="auth"){$Wc=true;foreach((array)$_SESSION["pwds"]as$Oi=>$fh){foreach($fh
as$N=>$Ji){foreach($Ji
as$V=>$F){if($F!==null){if($Wc){echo"<p id='logins'>".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");$Wc=false;}$Qb=$_SESSION["db"][$Oi][$N][$V];foreach(($Qb?array_keys($Qb):array(""))as$m)echo"<a href='".h(auth_url($Oi,$N,$V,$m))."'>($ec[$Oi]) ".h($V.($N!=""?"@".$this->serverName($N):"").($m!=""?" - $m":""))."</a><br>\n";}}}}}else{if($_GET["ns"]!==""&&!$Pe&&DB!=""){$g->select_db(DB);$T=table_status('',true);}echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=4.6.1");if(support("sql")){echo'<script',nonce(),'>
';if($T){$se=array();foreach($T
as$R=>$U)$se[]=preg_quote($R,'/');echo"var jushLinks = { $y: [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|",$se).")\\b/g ] };\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.$y;\n";}$eh=$g->server_info;echo'bodyLoad(\'',(is_object($g)?preg_replace('~^(\\d\\.?\\d).*~s','\\1',$eh):""),'\'',(preg_match('~MariaDB~',$eh)?", true":""),');
</script>
';}$this->databasesPrint($Pe);if(DB==""||!$Pe){echo"<p class='links'>".(support("sql")?"<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".lang(62)."</a>\n<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".lang(70)."</a>\n":"")."";if(support("dump"))echo"<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".lang(71)."</a>\n";}if($_GET["ns"]!==""&&!$Pe&&DB!=""){echo'<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".lang(72)."</a>\n";if(!$T)echo"<p class='message'>".lang(9)."\n";else$this->tablesPrint($T);}}}function
databasesPrint($Pe){global$b,$g;$l=$this->databases();echo'<form action="">
<p id="dbs">
';hidden_fields_get();$Ob=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<span title='".lang(73)."'>".lang(74)."</span>: ".($l?"<select name='db'>".optionlist(array(""=>"")+$l,DB)."</select>$Ob":"<input name='db' value='".h(DB)."' autocapitalize='off'>\n"),"<input type='submit' value='".lang(20)."'".($l?" class='hidden'":"").">\n";if($Pe!="db"&&DB!=""&&$g->select_db(DB)){if(support("scheme")){echo"<br>".lang(75).": <select name='ns'>".optionlist(array(""=>"")+$b->schemas(),$_GET["ns"])."</select>$Ob";if($_GET["ns"]!="")set_schema($_GET["ns"]);}}echo(isset($_GET["sql"])?'<input type="hidden" name="sql" value="">':(isset($_GET["schema"])?'<input type="hidden" name="schema" value="">':(isset($_GET["dump"])?'<input type="hidden" name="dump" value="">':(isset($_GET["privileges"])?'<input type="hidden" name="privileges" value="">':"")))),"</p></form>\n";}function
tablesPrint($T){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($T
as$R=>$P){$C=$this->tableName($P);if($C!=""){echo'<li><a href="'.h(ME).'select='.urlencode($R).'"'.bold($_GET["select"]==$R||$_GET["edit"]==$R,"select").">".lang(76)."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($R).'"'.bold(in_array($R,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])),(is_view($P)?"view":"structure"))." title='".lang(40)."'>$C</a>":"<span>$C</span>")."\n";}}echo"</ul>\n";}}$b=(function_exists('adminer_object')?adminer_object():new
Adminer);if($b->operators===null)$b->operators=$pf;function
page_header($Yh,$o="",$Xa=array(),$Zh=""){global$ca,$ia,$b,$ec,$y;page_headers();if(is_ajax()&&$o){page_messages($o);exit;}$ai=$Yh.($Zh!=""?": $Zh":"");$bi=strip_tags($ai.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".$b->name());echo'<!DOCTYPE html>
<html lang="',$ca,'" dir="',lang(77),'">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>',$bi,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=4.6.1"),'">
',script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=4.6.1");if($b->head()){echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.6.1"),'">
<link rel="apple-touch-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.6.1"),'">
';foreach($b->css()as$Ib){echo'<link rel="stylesheet" type="text/css" href="',h($Ib),'">
';}}echo'
<body class="',lang(77),' nojs">
';$Uc=get_temp_dir()."/adminer.version";if(!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($Uc)&&filemtime($Uc)+86400>time()){$Pi=unserialize(file_get_contents($Uc));$mg="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";if(openssl_verify($Pi["version"],base64_decode($Pi["signature"]),$mg)==1)$_COOKIE["adminer_version"]=$Pi["version"];}echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '$ia', '".js_escape(ME)."', '".get_token()."')");?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
js_escape(lang(78)),'\';
var thousandsSeparator = \'',js_escape(lang(5)),'\';
</script>

<div id="help" class="jush-',$y,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';if($Xa!==null){$A=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($A?$A:".").'">'.$ec[DRIVER].'</a> &raquo; ';$A=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$N=$b->serverName(SERVER);$N=($N!=""?$N:lang(32));if($Xa===false)echo"$N\n";else{echo"<a href='".($A?h($A):".")."' accesskey='1' title='Alt+Shift+1'>$N</a> &raquo; ";if($_GET["ns"]!=""||(DB!=""&&is_array($Xa)))echo'<a href="'.h($A."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> &raquo; ';if(is_array($Xa)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> &raquo; ';foreach($Xa
as$z=>$X){$Wb=(is_array($X)?$X[1]:h($X));if($Wb!="")echo"<a href='".h(ME."$z=").urlencode(is_array($X)?$X[0]:$X)."'>$Wb</a> &raquo; ";}}echo"$Yh\n";}}echo"<h2>$ai</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($o);$l=&get_session("dbs");if(DB!=""&&$l&&!in_array(DB,$l,true))$l=null;stop_session();define("PAGE_HEADER",1);}function
page_headers(){global$b;header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach($b->csp()as$Hb){$ud=array();foreach($Hb
as$z=>$X)$ud[]="$z $X";header("Content-Security-Policy: ".implode("; ",$ud));}$b->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$Ze;if(!$Ze)$Ze=base64_encode(rand_string());return$Ze;}function
page_messages($o){$Ci=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$Le=$_SESSION["messages"][$Ci];if($Le){echo"<div class='message'>".implode("</div>\n<div class='message'>",$Le)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$Ci]);}if($o)echo"<div class='error'>$o</div>\n";}function
page_footer($Pe=""){global$b,$fi;echo'</div>

';switch_lang();if($Pe!="auth"){echo'<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="',lang(79),'" id="logout">
<input type="hidden" name="token" value="',$fi,'">
</p>
</form>
';}echo'<div id="menu">
';$b->navigation($Pe);echo'</div>
',script("setupSubmitHighlight(document);");}function
int32($Se){while($Se>=2147483648)$Se-=4294967296;while($Se<=-2147483649)$Se+=4294967296;return(int)$Se;}function
long2str($W,$Ti){$Rg='';foreach($W
as$X)$Rg.=pack('V',$X);if($Ti)return
substr($Rg,0,end($W));return$Rg;}function
str2long($Rg,$Ti){$W=array_values(unpack('V*',str_pad($Rg,4*ceil(strlen($Rg)/4),"\0")));if($Ti)$W[]=strlen($Rg);return$W;}function
xxtea_mx($gj,$fj,$Ch,$Yd){return
int32((($gj>>5&0x7FFFFFF)^$fj<<2)+(($fj>>3&0x1FFFFFFF)^$gj<<4))^int32(($Ch^$fj)+($Yd^$gj));}function
encrypt_string($yh,$z){if($yh=="")return"";$z=array_values(unpack("V*",pack("H*",md5($z))));$W=str2long($yh,true);$Se=count($W)-1;$gj=$W[$Se];$fj=$W[0];$ng=floor(6+52/($Se+1));$Ch=0;while($ng-->0){$Ch=int32($Ch+0x9E3779B9);$lc=$Ch>>2&3;for($Ff=0;$Ff<$Se;$Ff++){$fj=$W[$Ff+1];$Re=xxtea_mx($gj,$fj,$Ch,$z[$Ff&3^$lc]);$gj=int32($W[$Ff]+$Re);$W[$Ff]=$gj;}$fj=$W[0];$Re=xxtea_mx($gj,$fj,$Ch,$z[$Ff&3^$lc]);$gj=int32($W[$Se]+$Re);$W[$Se]=$gj;}return
long2str($W,false);}function
decrypt_string($yh,$z){if($yh=="")return"";if(!$z)return
false;$z=array_values(unpack("V*",pack("H*",md5($z))));$W=str2long($yh,false);$Se=count($W)-1;$gj=$W[$Se];$fj=$W[0];$ng=floor(6+52/($Se+1));$Ch=int32($ng*0x9E3779B9);while($Ch){$lc=$Ch>>2&3;for($Ff=$Se;$Ff>0;$Ff--){$gj=$W[$Ff-1];$Re=xxtea_mx($gj,$fj,$Ch,$z[$Ff&3^$lc]);$fj=int32($W[$Ff]-$Re);$W[$Ff]=$fj;}$gj=$W[$Se];$Re=xxtea_mx($gj,$fj,$Ch,$z[$Ff&3^$lc]);$fj=int32($W[0]-$Re);$W[0]=$fj;$Ch=int32($Ch-0x9E3779B9);}return
long2str($W,true);}$g='';$td=$_SESSION["token"];if(!$td)$_SESSION["token"]=rand(1,1e6);$fi=get_token();$Uf=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($z)=explode(":",$X);$Uf[$z]=$X;}}function
add_invalid_login(){global$b;$hd=file_open_lock(get_temp_dir()."/adminer.invalid");if(!$hd)return;$Rd=unserialize(stream_get_contents($hd));$Vh=time();if($Rd){foreach($Rd
as$Sd=>$X){if($X[0]<$Vh)unset($Rd[$Sd]);}}$Qd=&$Rd[$b->bruteForceKey()];if(!$Qd)$Qd=array($Vh+30*60,0);$Qd[1]++;file_write_unlock($hd,serialize($Rd));}function
check_invalid_login(){global$b;$Rd=unserialize(@file_get_contents(get_temp_dir()."/adminer.invalid"));$Qd=$Rd[$b->bruteForceKey()];$Ye=($Qd[1]>29?$Qd[0]-time():0);if($Ye>0)auth_error(lang(80,ceil($Ye/60)));}$La=$_POST["auth"];if($La){session_regenerate_id();$Oi=$La["driver"];$N=$La["server"];$V=$La["username"];$F=(string)$La["password"];$m=$La["db"];set_password($Oi,$N,$V,$F);$_SESSION["db"][$Oi][$N][$V][$m]=true;if($La["permanent"]){$z=base64_encode($Oi)."-".base64_encode($N)."-".base64_encode($V)."-".base64_encode($m);$gg=$b->permanentLogin(true);$Uf[$z]="$z:".base64_encode($gg?encrypt_string($F,$gg):"");cookie("adminer_permanent",implode(" ",$Uf));}if(count($_POST)==1||DRIVER!=$Oi||SERVER!=$N||$_GET["username"]!==$V||DB!=$m)redirect(auth_url($Oi,$N,$V,$m));}elseif($_POST["logout"]){if($td&&!verify_token()){page_header(lang(79),lang(81));page_footer("db");exit;}else{foreach(array("pwds","db","dbs","queries")as$z)set_session($z,null);unset_permanent();redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),lang(82).' '.lang(83,'https://sourceforge.net/donate/index.php?group_id=264133'));}}elseif($Uf&&!$_SESSION["pwds"]){session_regenerate_id();$gg=$b->permanentLogin();foreach($Uf
as$z=>$X){list(,$jb)=explode(":",$X);list($Oi,$N,$V,$m)=array_map('base64_decode',explode("-",$z));set_password($Oi,$N,$V,decrypt_string(base64_decode($jb),$gg));$_SESSION["db"][$Oi][$N][$V][$m]=true;}}function
unset_permanent(){global$Uf;foreach($Uf
as$z=>$X){list($Oi,$N,$V,$m)=array_map('base64_decode',explode("-",$z));if($Oi==DRIVER&&$N==SERVER&&$V==$_GET["username"]&&$m==DB)unset($Uf[$z]);}cookie("adminer_permanent",implode(" ",$Uf));}function
auth_error($o){global$b,$td;$gh=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$gh]||$_GET[$gh])&&!$td)$o=lang(84);else{add_invalid_login();$F=get_password();if($F!==null){if($F===false)$o.='<br>'.lang(85,target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent();}}if(!$_COOKIE[$gh]&&$_GET[$gh]&&ini_bool("session.use_only_cookies"))$o=lang(86);$Hf=session_get_cookie_params();cookie("adminer_key",($_COOKIE["adminer_key"]?$_COOKIE["adminer_key"]:rand_string()),$Hf["lifetime"]);page_header(lang(36),$o,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".lang(87)."\n";echo"</div>\n";$b->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])){if(!class_exists("Min_DB")){unset($_SESSION["pwds"][DRIVER]);unset_permanent();page_header(lang(88),lang(89,implode(", ",$ag)),false);page_footer("auth");exit;}list($yd,$Wf)=explode(":",SERVER,2);if(is_numeric($Wf)&&$Wf<1024)auth_error(lang(90));check_invalid_login();$g=connect();$n=new
Min_Driver($g);}$ue=null;if(!is_object($g)||($ue=$b->login($_GET["username"],get_password()))!==true)auth_error((is_string($g)?h($g):(is_string($ue)?$ue:lang(91))));if($La&&$_POST["token"])$_POST["token"]=$fi;$o='';if($_POST){if(!verify_token()){$Ld="max_input_vars";$Fe=ini_get($Ld);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$z){$X=ini_get($z);if($X&&(!$Fe||$X<$Fe)){$Ld=$z;$Fe=$X;}}}$o=(!$_POST["token"]&&$Fe?lang(92,"'$Ld'"):lang(81).' '.lang(93));}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$o=lang(94,"'post_max_size'");if(isset($_GET["sql"]))$o.=' '.lang(95);}if(!ini_bool("session.use_cookies")||@ini_set("session.use_cookies",false)!==false)session_write_close();function
select($H,$h=null,$xf=array(),$_=0){global$y;$se=array();$x=array();$e=array();$Ua=array();$ui=array();$I=array();odd('');for($t=0;(!$_||$t<$_)&&($J=$H->fetch_row());$t++){if(!$t){echo"<table cellspacing='0' class='nowrap'>\n","<thead><tr>";for($Xd=0;$Xd<count($J);$Xd++){$p=$H->fetch_field();$C=$p->name;$wf=$p->orgtable;$vf=$p->orgname;$I[$p->table]=$wf;if($xf&&$y=="sql")$se[$Xd]=($C=="table"?"table=":($C=="possible_keys"?"indexes=":null));elseif($wf!=""){if(!isset($x[$wf])){$x[$wf]=array();foreach(indexes($wf,$h)as$w){if($w["type"]=="PRIMARY"){$x[$wf]=array_flip($w["columns"]);break;}}$e[$wf]=$x[$wf];}if(isset($e[$wf][$vf])){unset($e[$wf][$vf]);$x[$wf][$vf]=$Xd;$se[$Xd]=$wf;}}if($p->charsetnr==63)$Ua[$Xd]=true;$ui[$Xd]=$p->type;echo"<th".($wf!=""||$p->name!=$vf?" title='".h(($wf!=""?"$wf.":"").$vf)."'":"").">".h($C).($xf?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($C),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr".odd().">";foreach($J
as$z=>$X){if($X===null)$X="<i>NULL</i>";elseif($Ua[$z]&&!is_utf8($X))$X="<i>".lang(45,strlen($X))."</i>";elseif(!strlen($X))$X="&nbsp;";else{$X=h($X);if($ui[$z]==254)$X="<code>$X</code>";}if(isset($se[$z])&&!$e[$se[$z]]){if($xf&&$y=="sql"){$R=$J[array_search("table=",$se)];$A=$se[$z].urlencode($xf[$R]!=""?$xf[$R]:$R);}else{$A="edit=".urlencode($se[$z]);foreach($x[$se[$z]]as$nb=>$Xd)$A.="&where".urlencode("[".bracket_escape($nb)."]")."=".urlencode($J[$Xd]);}$X="<a href='".h(ME.$A)."'>$X</a>";}echo"<td>$X";}}echo($t?"</table>":"<p class='message'>".lang(12))."\n";return$I;}function
referencable_primary($ah){$I=array();foreach(table_status('',true)as$Gh=>$R){if($Gh!=$ah&&fk_support($R)){foreach(fields($Gh)as$p){if($p["primary"]){if($I[$Gh]){unset($I[$Gh]);break;}$I[$Gh]=$p;}}}}return$I;}function
textarea($C,$Y,$K=10,$sb=80){global$y;echo"<textarea name='$C' rows='$K' cols='$sb' class='sqlarea jush-$y' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
edit_type($z,$p,$qb,$dd=array(),$Lc=array()){global$zh,$ui,$Ai,$kf;$U=$p["type"];echo'<td><select name="',h($z),'[type]" class="type" aria-labelledby="label-type">';if($U&&!isset($ui[$U])&&!isset($dd[$U])&&!in_array($U,$Lc))$Lc[]=$U;if($dd)$zh[lang(96)]=$dd;echo
optionlist(array_merge($Lc,$zh),$U),'</select>
',on_help("getTarget(event).value",1),script("mixin(qsl('select'), {onfocus: function () { lastType = selectValue(this); }, onchange: editingTypeChange});",""),'<td><input name="',h($z),'[length]" value="',h($p["length"]),'" size="3"',(!$p["length"]&&preg_match('~var(char|binary)$~',$U)?" class='required'":""),' aria-labelledby="label-length">',script("mixin(qsl('input'), {onfocus: editingLengthFocus, oninput: editingLengthChange});",""),'<td class="options">';echo"<select name='".h($z)."[collation]'".(preg_match('~(char|text|enum|set)$~',$U)?"":" class='hidden'").'><option value="">('.lang(97).')'.optionlist($qb,$p["collation"]).'</select>',($Ai?"<select name='".h($z)."[unsigned]'".(!$U||preg_match(number_type(),$U)?"":" class='hidden'").'><option>'.optionlist($Ai,$p["unsigned"]).'</select>':''),(isset($p['on_update'])?"<select name='".h($z)."[on_update]'".(preg_match('~timestamp|datetime~',$U)?"":" class='hidden'").'>'.optionlist(array(""=>"(".lang(98).")","CURRENT_TIMESTAMP"),$p["on_update"]).'</select>':''),($dd?"<select name='".h($z)."[on_delete]'".(preg_match("~`~",$U)?"":" class='hidden'")."><option value=''>(".lang(99).")".optionlist(explode("|",$kf),$p["on_delete"])."</select> ":" ");}function
process_length($pe){global$wc;return(preg_match("~^\\s*\\(?\\s*$wc(?:\\s*,\\s*$wc)*+\\s*\\)?\\s*\$~",$pe)&&preg_match_all("~$wc~",$pe,$_e)?"(".implode(",",$_e[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$pe)));}function
process_type($p,$ob="COLLATE"){global$Ai;return" $p[type]".process_length($p["length"]).(preg_match(number_type(),$p["type"])&&in_array($p["unsigned"],$Ai)?" $p[unsigned]":"").(preg_match('~char|text|enum|set~',$p["type"])&&$p["collation"]?" $ob ".q($p["collation"]):"");}function
process_field($p,$si){global$y;$Sb=$p["default"];return
array(idf_escape(trim($p["field"])),process_type($si),($p["null"]?" NULL":" NOT NULL"),(isset($Sb)?" DEFAULT ".(preg_match('~char|binary|text|enum|set~',$p["type"])||preg_match('~^(?![a-z])~i',$Sb)?q($Sb):$Sb):""),(preg_match('~timestamp|datetime~',$p["type"])&&$p["on_update"]?" ON UPDATE $p[on_update]":""),(support("comment")&&$p["comment"]!=""?" COMMENT ".q($p["comment"]):""),($p["auto_increment"]?auto_increment():null),);}function
type_class($U){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$z=>$X){if(preg_match("~$z|$X~",$U))return" class='$z'";}}function
edit_fields($q,$qb,$U="TABLE",$dd=array(),$wb=false){global$Md;$q=array_values($q);echo'<thead><tr>
';if($U=="PROCEDURE"){echo'<td>&nbsp;';}echo'<th id="label-name">',($U=="TABLE"?lang(100):lang(101)),'<td id="label-type">',lang(47),'<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">',lang(102),'<td>',lang(103);if($U=="TABLE"){echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="',lang(49),'">AI</acronym>',doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",'sqlite'=>"autoinc.html",'pgsql'=>"datatype.html#DATATYPE-SERIAL",'mssql'=>"ms186775.aspx",)),'<td id="label-default">',lang(50),(support("comment")?"<td id='label-comment'".($wb?"":" class='hidden'").">".lang(48):"");}echo'<td>',"<input type='image' class='icon' name='add[".(support("move_col")?0:count($q))."]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.6.1")."' alt='+' title='".lang(104)."'>".script("row_count = ".count($q).";"),'</thead>
<tbody>
',script("qsl('tbody').onkeydown = editingKeydown;");foreach($q
as$t=>$p){$t++;$yf=$p[($_POST?"orig":"field")];$ac=(isset($_POST["add"][$t-1])||(isset($p["field"])&&!$_POST["drop_col"][$t]))&&(support("drop_col")||$yf=="");echo'<tr',($ac?"":" style='display: none;'"),'>
',($U=="PROCEDURE"?"<td>".html_select("fields[$t][inout]",explode("|",$Md),$p["inout"]):""),'<th>';if($ac){echo'<input name="fields[',$t,'][field]" value="',h($p["field"]),'" maxlength="64" autocapitalize="off" aria-labelledby="label-name">',script("qsl('input').oninput = function () { editingNameChange.call(this);".($p["field"]!=""||count($q)>1?"":" editingAddRow.call(this);")." };","");}echo'<input type="hidden" name="fields[',$t,'][orig]" value="',h($yf),'">
';edit_type("fields[$t]",$p,$qb,$dd);if($U=="TABLE"){echo'<td>',checkbox("fields[$t][null]",1,$p["null"],"","","block","label-null"),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$t,'"';if($p["auto_increment"]){echo' checked';}echo' aria-labelledby="label-ai">',script("qsl('input').onclick = function () { var field = this.form['fields[' + this.value + '][field]']; if (!field.value) { field.value = 'id'; field.oninput(); } }"),'</label><td>',checkbox("fields[$t][has_default]",1,$p["has_default"],"","","","label-default"),'<input name="fields[',$t,'][default]" value="',h($p["default"]),'" aria-labelledby="label-default">',script("qsl('input').oninput = function () { this.previousSibling.checked = true; }",""),(support("comment")?"<td".($wb?"":" class='hidden'")."><input name='fields[$t][comment]' value='".h($p["comment"])."' maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");}echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.6.1")."' alt='+' title='".lang(104)."'>&nbsp;".script("qsl('input').onclick = partial(editingAddRow, 1);","")."<input type='image' class='icon' name='up[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=up.gif&version=4.6.1")."' alt='^' title='".lang(105)."'>&nbsp;".script("qsl('input').onclick = partial(editingMoveRow, 1);","")."<input type='image' class='icon' name='down[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=down.gif&version=4.6.1")."' alt='v' title='".lang(106)."'>&nbsp;".script("qsl('input').onclick = partial(editingMoveRow, 0);",""):""),($yf==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.6.1")."' alt='x' title='".lang(107)."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'fields\$1[field]');"):"");}}function
process_fields(&$q){$D=0;if($_POST["up"]){$je=0;foreach($q
as$z=>$p){if(key($_POST["up"])==$z){unset($q[$z]);array_splice($q,$je,0,array($p));break;}if(isset($p["field"]))$je=$D;$D++;}}elseif($_POST["down"]){$fd=false;foreach($q
as$z=>$p){if(isset($p["field"])&&$fd){unset($q[key($_POST["down"])]);array_splice($q,$D,0,array($fd));break;}if(key($_POST["down"])==$z)$fd=$p;$D++;}}elseif($_POST["add"]){$q=array_values($q);array_splice($q,key($_POST["add"]),0,array(array()));}elseif(!$_POST["drop_col"])return
false;return
true;}function
normalize_enum($B){return"'".str_replace("'","''",addcslashes(stripcslashes(str_replace($B[0][0].$B[0][0],$B[0][0],substr($B[0],1,-1))),'\\'))."'";}function
grant($kd,$ig,$e,$jf){if(!$ig)return
true;if($ig==array("ALL PRIVILEGES","GRANT OPTION"))return($kd=="GRANT"?queries("$kd ALL PRIVILEGES$jf WITH GRANT OPTION"):queries("$kd ALL PRIVILEGES$jf")&&queries("$kd GRANT OPTION$jf"));return
queries("$kd ".preg_replace('~(GRANT OPTION)\\([^)]*\\)~','\\1',implode("$e, ",$ig).$e).$jf);}function
drop_create($fc,$i,$gc,$Sh,$ic,$te,$Ke,$Ie,$Je,$gf,$Ve){if($_POST["drop"])query_redirect($fc,$te,$Ke);elseif($gf=="")query_redirect($i,$te,$Je);elseif($gf!=$Ve){$Gb=queries($i);queries_redirect($te,$Ie,$Gb&&queries($fc));if($Gb)queries($gc);}else
queries_redirect($te,$Ie,queries($Sh)&&queries($ic)&&queries($fc)&&queries($i));}function
create_trigger($jf,$J){global$y;$Xh=" $J[Timing] $J[Event]".($J["Event"]=="UPDATE OF"?" ".idf_escape($J["Of"]):"");return"CREATE TRIGGER ".idf_escape($J["Trigger"]).($y=="mssql"?$jf.$Xh:$Xh.$jf).rtrim(" $J[Type]\n$J[Statement]",";").";";}function
create_routine($Ng,$J){global$Md,$y;$O=array();$q=(array)$J["fields"];ksort($q);foreach($q
as$p){if($p["field"]!="")$O[]=(preg_match("~^($Md)\$~",$p["inout"])?"$p[inout] ":"").idf_escape($p["field"]).process_type($p,"CHARACTER SET");}$Tb=rtrim("\n$J[definition]",";");return"CREATE $Ng ".idf_escape(trim($J["name"]))." (".implode(", ",$O).")".(isset($_GET["function"])?" RETURNS".process_type($J["returns"],"CHARACTER SET"):"").($J["language"]?" LANGUAGE $J[language]":"").($y=="pgsql"?" AS ".q($Tb):"$Tb;");}function
remove_definer($G){return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~','`@`(%|\\1)',logged_user()).'`~','\\1',$G);}function
format_foreign_key($r){global$kf;return" FOREIGN KEY (".implode(", ",array_map('idf_escape',$r["source"])).") REFERENCES ".table($r["table"])." (".implode(", ",array_map('idf_escape',$r["target"])).")".(preg_match("~^($kf)\$~",$r["on_delete"])?" ON DELETE $r[on_delete]":"").(preg_match("~^($kf)\$~",$r["on_update"])?" ON UPDATE $r[on_update]":"");}function
tar_file($Uc,$ci){$I=pack("a100a8a8a8a12a12",$Uc,644,0,0,decoct($ci->size),decoct(time()));$hb=8*32;for($t=0;$t<strlen($I);$t++)$hb+=ord($I[$t]);$I.=sprintf("%06o",$hb)."\0 ";echo$I,str_repeat("\0",512-strlen($I));$ci->send();echo
str_repeat("\0",511-($ci->size+511)%512);}function
ini_bytes($Ld){$X=ini_get($Ld);switch(strtolower(substr($X,-1))){case'g':$X*=1024;case'm':$X*=1024;case'k':$X*=1024;}return$X;}function
doc_link($Sf,$Th="<sup>?</sup>"){global$y,$g;$eh=$g->server_info;$Pi=preg_replace('~^(\\d\\.?\\d).*~s','\\1',$eh);$Fi=array('sql'=>"https://dev.mysql.com/doc/refman/$Pi/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/$Pi/static/",'mssql'=>"https://msdn.microsoft.com/library/",'oracle'=>"https://download.oracle.com/docs/cd/B19306_01/server.102/b14200/",);if(preg_match('~MariaDB~',$eh)){$Fi['sql']="https://mariadb.com/kb/en/library/";$Sf['sql']=(isset($Sf['mariadb'])?$Sf['mariadb']:str_replace(".html","/",$Sf['sql']));}return($Sf[$y]?"<a href='$Fi[$y]$Sf[$y]'".target_blank().">$Th</a>":"");}function
ob_gzencode($Q){return
gzencode($Q);}function
db_size($m){global$g;if(!$g->select_db($m))return"?";$I=0;foreach(table_status()as$S)$I+=$S["Data_length"]+$S["Index_length"];return
format_number($I);}function
set_utf8mb4($i){global$g;static$O=false;if(!$O&&preg_match('~\butf8mb4~i',$i)){$O=true;echo"SET NAMES ".charset($g).";\n\n";}}function
connect_error(){global$b,$g,$fi,$o,$ec;if(DB!=""){header("HTTP/1.1 404 Not Found");page_header(lang(35).": ".h(DB),lang(108),true);}else{if($_POST["db"]&&!$o)queries_redirect(substr(ME,0,-1),lang(109),drop_databases($_POST["db"]));page_header(lang(110),$o,false);echo"<p class='links'>\n";foreach(array('database'=>lang(111),'privileges'=>lang(69),'processlist'=>lang(112),'variables'=>lang(113),'status'=>lang(114),)as$z=>$X){if(support($z))echo"<a href='".h(ME)."$z='>$X</a>\n";}echo"<p>".lang(115,$ec[DRIVER],"<b>".h($g->server_info)."</b>","<b>$g->extension</b>")."\n","<p>".lang(116,"<b>".h(logged_user())."</b>")."\n";$l=$b->databases();if($l){$Ug=support("scheme");$qb=collations();echo"<form action='' method='post'>\n","<table cellspacing='0' class='checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>&nbsp;":"")."<th>".lang(35)." - <a href='".h(ME)."refresh=1'>".lang(117)."</a>"."<td>".lang(118)."<td>".lang(119)."<td>".lang(120)." - <a href='".h(ME)."dbsize=1'>".lang(121)."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$l=($_GET["dbsize"]?count_tables($l):array_flip($l));foreach($l
as$m=>$T){$Mg=h(ME)."db=".urlencode($m);$u=h("Db-".$m);echo"<tr".odd().">".(support("database")?"<td>".checkbox("db[]",$m,in_array($m,(array)$_POST["db"]),"","","",$u):""),"<th><a href='$Mg' id='$m'>".h($m)."</a>";$pb=nbsp(db_collation($m,$qb));echo"<td>".(support("database")?"<a href='$Mg".($Ug?"&amp;ns=":"")."&amp;database=' title='".lang(65)."'>$pb</a>":$pb),"<td align='right'><a href='$Mg&amp;schema=' id='tables-".h($m)."' title='".lang(68)."'>".($_GET["dbsize"]?$T:"?")."</a>","<td align='right' id='size-".h($m)."'>".($_GET["dbsize"]?db_size($m):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'>\n"."<fieldset><legend>".lang(122)." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".lang(123)."'>".confirm()."\n"."</div></fieldset>\n"."</div>\n":""),"<input type='hidden' name='token' value='$fi'>\n","</form>\n",script("tableCheck();");}}page_footer("db");}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?$g->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}connect_error();exit;}if(support("scheme")&&DB!=""&&$_GET["ns"]!==""){if(!isset($_GET["ns"]))redirect(preg_replace('~ns=[^&]*&~','',ME)."ns=".get_schema());if(!set_schema($_GET["ns"])){header("HTTP/1.1 404 Not Found");page_header(lang(75).": ".h($_GET["ns"]),lang(124),true);page_footer("ns");exit;}}$kf="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";class
TmpFile{var$handler;var$size;function
__construct(){$this->handler=tmpfile();}function
write($Ab){$this->size+=strlen($Ab);fwrite($this->handler,$Ab);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}$wc="'(?:''|[^'\\\\]|\\\\.)*'";$Md="IN|OUT|INOUT";if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$q=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$L=array(idf_escape($_GET["field"]));$H=$n->select($a,$L,array(where($_GET,$q)),$L);$J=($H?$H->fetch_row():array());echo$n->value($J[0],$q[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$q=fields($a);if(!$q)$o=error();$S=table_status1($a,true);$C=$b->tableName($S);page_header(($q&&is_view($S)?$S['Engine']=='materialized view'?lang(125):lang(126):lang(127)).": ".($C!=""?$C:h($a)),$o);$b->selectLinks($S);$vb=$S["Comment"];if($vb!="")echo"<p class='nowrap'>".lang(48).": ".h($vb)."\n";if($q)$b->tableStructurePrint($q);if(!is_view($S)){if(support("indexes")){echo"<h3 id='indexes'>".lang(128)."</h3>\n";$x=indexes($a);if($x)$b->tableIndexesPrint($x);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.lang(129)."</a>\n";}if(fk_support($S)){echo"<h3 id='foreign-keys'>".lang(96)."</h3>\n";$dd=foreign_keys($a);if($dd){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(130)."<td>".lang(131)."<td>".lang(99)."<td>".lang(98)."<td>&nbsp;</thead>\n";foreach($dd
as$C=>$r){echo"<tr title='".h($C)."'>","<th><i>".implode("</i>, <i>",array_map('h',$r["source"]))."</i>","<td><a href='".h($r["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($r["db"]),ME):($r["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($r["ns"]),ME):ME))."table=".urlencode($r["table"])."'>".($r["db"]!=""?"<b>".h($r["db"])."</b>.":"").($r["ns"]!=""?"<b>".h($r["ns"])."</b>.":"").h($r["table"])."</a>","(<i>".implode("</i>, <i>",array_map('h',$r["target"]))."</i>)","<td>".nbsp($r["on_delete"])."\n","<td>".nbsp($r["on_update"])."\n",'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($C)).'">'.lang(132).'</a>';}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.lang(133)."</a>\n";}}if(support(is_view($S)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".lang(134)."</h3>\n";$ri=triggers($a);if($ri){echo"<table cellspacing='0'>\n";foreach($ri
as$z=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($z)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($z))."'>".lang(132)."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.lang(135)."</a>\n";}}elseif(isset($_GET["schema"])){page_header(lang(68),"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$Ih=array();$Jh=array();$ea=($_GET["schema"]?$_GET["schema"]:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ea,$_e,PREG_SET_ORDER);foreach($_e
as$t=>$B){$Ih[$B[1]]=array($B[2],$B[3]);$Jh[]="\n\t'".js_escape($B[1])."': [ $B[2], $B[3] ]";}$gi=0;$Ra=-1;$Tg=array();$zg=array();$ne=array();foreach(table_status('',true)as$R=>$S){if(is_view($S))continue;$Xf=0;$Tg[$R]["fields"]=array();foreach(fields($R)as$C=>$p){$Xf+=1.25;$p["pos"]=$Xf;$Tg[$R]["fields"][$C]=$p;}$Tg[$R]["pos"]=($Ih[$R]?$Ih[$R]:array($gi,0));foreach($b->foreignKeys($R)as$X){if(!$X["db"]){$le=$Ra;if($Ih[$R][1]||$Ih[$X["table"]][1])$le=min(floatval($Ih[$R][1]),floatval($Ih[$X["table"]][1]))-1;else$Ra-=.1;while($ne[(string)$le])$le-=.0001;$Tg[$R]["references"][$X["table"]][(string)$le]=array($X["source"],$X["target"]);$zg[$X["table"]][$R][(string)$le]=$X["target"];$ne[(string)$le]=true;}}$gi=max($gi,$Tg[$R]["pos"][0]+2.5+$Xf);}echo'<div id="schema" style="height: ',$gi,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",",$Jh)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$gi,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach($Tg
as$C=>$R){echo"<div class='table' style='top: ".$R["pos"][0]."em; left: ".$R["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($C).'"><b>'.h($C)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");foreach($R["fields"]as$p){$X='<span'.type_class($p["type"]).' title="'.h($p["full_type"].($p["null"]?" NULL":'')).'">'.h($p["field"]).'</span>';echo"<br>".($p["primary"]?"<i>$X</i>":$X);}foreach((array)$R["references"]as$Ph=>$_g){foreach($_g
as$le=>$wg){$me=$le-$Ih[$C][1];$t=0;foreach($wg[0]as$nh)echo"\n<div class='references' title='".h($Ph)."' id='refs$le-".($t++)."' style='left: $me"."em; top: ".$R["fields"][$nh]["pos"]."em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: ".(-$me)."em;'></div></div>";}}foreach((array)$zg[$C]as$Ph=>$_g){foreach($_g
as$le=>$e){$me=$le-$Ih[$C][1];$t=0;foreach($e
as$Oh)echo"\n<div class='references' title='".h($Ph)."' id='refd$le-".($t++)."' style='left: $me"."em; top: ".$R["fields"][$Oh]["pos"]."em; height: 1.25em; background: url(".h(preg_replace("~\\?.*~","",ME)."?file=arrow.gif) no-repeat right center;&version=4.6.1")."'><div style='height: .5em; border-bottom: 1px solid Gray; width: ".(-$me)."em;'></div></div>";}}echo"\n</div>\n";}foreach($Tg
as$C=>$R){foreach((array)$R["references"]as$Ph=>$_g){foreach($_g
as$le=>$wg){$Oe=$gi;$De=-10;foreach($wg[0]as$z=>$nh){$Yf=$R["pos"][0]+$R["fields"][$nh]["pos"];$Zf=$Tg[$Ph]["pos"][0]+$Tg[$Ph]["fields"][$wg[1][$z]]["pos"];$Oe=min($Oe,$Yf,$Zf);$De=max($De,$Yf,$Zf);}echo"<div class='references' id='refl$le' style='left: $le"."em; top: $Oe"."em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: ".($De-$Oe)."em;'></div></div>\n";}}}echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">',lang(136),'</a>
';}elseif(isset($_GET["dump"])){$a=$_GET["dump"];if($_POST&&!$o){$Db="";foreach(array("output","format","db_style","routines","events","table_style","auto_increment","triggers","data_style")as$z)$Db.="&$z=".urlencode($_POST[$z]);cookie("adminer_export",substr($Db,1));$T=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);$Ic=dump_headers((count($T)==1?key($T):DB),(DB==""||count($T)>1));$Ud=preg_match('~sql~',$_POST["format"]);if($Ud){echo"-- Adminer $ia ".$ec[DRIVER]." dump\n\n";if($y=="sql"){echo"SET NAMES utf8;
SET time_zone = '+00:00';
".($_POST["data_style"]?"SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";$g->query("SET time_zone = '+00:00';");}}$_h=$_POST["db_style"];$l=array(DB);if(DB==""){$l=$_POST["databases"];if(is_string($l))$l=explode("\n",rtrim(str_replace("\r","",$l),"\n"));}foreach((array)$l
as$m){$b->dumpDatabase($m);if($g->select_db($m)){if($Ud&&preg_match('~CREATE~',$_h)&&($i=$g->result("SHOW CREATE DATABASE ".idf_escape($m),1))){set_utf8mb4($i);if($_h=="DROP+CREATE")echo"DROP DATABASE IF EXISTS ".idf_escape($m).";\n";echo"$i;\n";}if($Ud){if($_h)echo
use_sql($m).";\n\n";$Df="";if($_POST["routines"]){foreach(array("FUNCTION","PROCEDURE")as$Ng){foreach(get_rows("SHOW $Ng STATUS WHERE Db = ".q($m),null,"-- ")as$J){$i=remove_definer($g->result("SHOW CREATE $Ng ".idf_escape($J["Name"]),2));set_utf8mb4($i);$Df.=($_h!='DROP+CREATE'?"DROP $Ng IF EXISTS ".idf_escape($J["Name"]).";;\n":"")."$i;;\n\n";}}}if($_POST["events"]){foreach(get_rows("SHOW EVENTS",null,"-- ")as$J){$i=remove_definer($g->result("SHOW CREATE EVENT ".idf_escape($J["Name"]),3));set_utf8mb4($i);$Df.=($_h!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($J["Name"]).";;\n":"")."$i;;\n\n";}}if($Df)echo"DELIMITER ;;\n\n$Df"."DELIMITER ;\n\n";}if($_POST["table_style"]||$_POST["data_style"]){$Ri=array();foreach(table_status('',true)as$C=>$S){$R=(DB==""||in_array($C,(array)$_POST["tables"]));$Lb=(DB==""||in_array($C,(array)$_POST["data"]));if($R||$Lb){if($Ic=="tar"){$ci=new
TmpFile;ob_start(array($ci,'write'),1e5);}$b->dumpTable($C,($R?$_POST["table_style"]:""),(is_view($S)?2:0));if(is_view($S))$Ri[]=$C;elseif($Lb){$q=fields($C);$b->dumpData($C,$_POST["data_style"],"SELECT *".convert_fields($q,$q)." FROM ".table($C));}if($Ud&&$_POST["triggers"]&&$R&&($ri=trigger_sql($C)))echo"\nDELIMITER ;;\n$ri\nDELIMITER ;\n";if($Ic=="tar"){ob_end_flush();tar_file((DB!=""?"":"$m/")."$C.csv",$ci);}elseif($Ud)echo"\n";}}foreach($Ri
as$Qi)$b->dumpTable($Qi,$_POST["table_style"],1);if($Ic=="tar")echo
pack("x512");}}}if($Ud)echo"-- ".$g->result("SELECT NOW()")."\n";exit;}page_header(lang(71),$o,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table cellspacing="0">
';$Pb=array('','USE','DROP+CREATE','CREATE');$Kh=array('','DROP+CREATE','CREATE');$Mb=array('','TRUNCATE+INSERT','INSERT');if($y=="sql")$Mb[]='INSERT+UPDATE';parse_str($_COOKIE["adminer_export"],$J);if(!$J)$J=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($J["events"])){$J["routines"]=$J["events"]=($_GET["dump"]=="");$J["triggers"]=$J["table_style"];}echo"<tr><th>".lang(137)."<td>".html_select("output",$b->dumpOutput(),$J["output"],0)."\n";echo"<tr><th>".lang(138)."<td>".html_select("format",$b->dumpFormat(),$J["format"],0)."\n";echo($y=="sqlite"?"":"<tr><th>".lang(35)."<td>".html_select('db_style',$Pb,$J["db_style"]).(support("routine")?checkbox("routines",1,$J["routines"],lang(139)):"").(support("event")?checkbox("events",1,$J["events"],lang(140)):"")),"<tr><th>".lang(119)."<td>".html_select('table_style',$Kh,$J["table_style"]).checkbox("auto_increment",1,$J["auto_increment"],lang(49)).(support("trigger")?checkbox("triggers",1,$J["triggers"],lang(134)):""),"<tr><th>".lang(141)."<td>".html_select('data_style',$Mb,$J["data_style"]),'</table>
<p><input type="submit" value="',lang(71),'">
<input type="hidden" name="token" value="',$fi,'">

<table cellspacing="0">
',script("qsl('table').onclick = dumpClick;");$cg=array();if(DB!=""){$fb=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$fb>".lang(119)."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".lang(141)."<input type='checkbox' id='check-data'$fb></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$Ri="";$Lh=tables_list();foreach($Lh
as$C=>$U){$bg=preg_replace('~_.*~','',$C);$fb=($a==""||$a==(substr($a,-1)=="%"?"$bg%":$C));$fg="<tr><td>".checkbox("tables[]",$C,$fb,$C,"","block");if($U!==null&&!preg_match('~table~i',$U))$Ri.="$fg\n";else
echo"$fg<td align='right'><label class='block'><span id='Rows-".h($C)."'></span>".checkbox("data[]",$C,$fb)."</label>\n";$cg[$bg]++;}echo$Ri;if($Lh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".lang(35)."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$l=$b->databases();if($l){foreach($l
as$m){if(!information_schema($m)){$bg=preg_replace('~_.*~','',$m);echo"<tr><td>".checkbox("databases[]",$m,$a==""||$a=="$bg%",$m,"","block")."\n";$cg[$bg]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$Wc=true;foreach($cg
as$z=>$X){if($z!=""&&$X>1){echo($Wc?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$z%")."'>".h($z)."</a>";$Wc=false;}}}elseif(isset($_GET["privileges"])){page_header(lang(69));echo'<p class="links"><a href="'.h(ME).'user=">'.lang(142)."</a>";$H=$g->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$kd=$H;if(!$H)$H=$g->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($kd?"":"<input type='hidden' name='grant' value=''>\n"),"<table cellspacing='0'>\n","<thead><tr><th>".lang(33)."<th>".lang(32)."<th>&nbsp;</thead>\n";while($J=$H->fetch_assoc())echo'<tr'.odd().'><td>'.h($J["User"])."<td>".h($J["Host"]).'<td><a href="'.h(ME.'user='.urlencode($J["User"]).'&host='.urlencode($J["Host"])).'">'.lang(10)."</a>\n";if(!$kd||DB!="")echo"<tr".odd()."><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".lang(10)."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$o&&$_POST["export"]){dump_headers("sql");$b->dumpTable("","");$b->dumpData("","table",$_POST["query"]);exit;}restart_session();$wd=&get_session("queries");$vd=&$wd[DB];if(!$o&&$_POST["clear"]){$vd=array();redirect(remove_from_uri("history"));}page_header((isset($_GET["import"])?lang(70):lang(62)),$o);if(!$o&&$_POST){$hd=false;if(!isset($_GET["import"]))$G=$_POST["query"];elseif($_POST["webfile"]){$rh=$b->importServerPath();$hd=@fopen((file_exists($rh)?$rh:"compress.zlib://$rh.gz"),"rb");$G=($hd?fread($hd,1e6):false);}else$G=get_file("sql_file",true);if(is_string($G)){if(function_exists('memory_get_usage'))@ini_set("memory_limit",max(ini_bytes("memory_limit"),2*strlen($G)+memory_get_usage()+8e6));if($G!=""&&strlen($G)<1e6){$ng=$G.(preg_match("~;[ \t\r\n]*\$~",$G)?"":";");if(!$vd||reset(end($vd))!=$ng){restart_session();$vd[]=array($ng,time());set_session("queries",$wd);stop_session();}}$oh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Vb=";";$D=0;$tc=true;$h=connect();if(is_object($h)&&DB!="")$h->select_db(DB);$ub=0;$yc=array();$Jf='[\'"'.($y=="sql"?'`#':($y=="sqlite"?'`[':($y=="mssql"?'[':''))).']|/\\*|-- |$'.($y=="pgsql"?'|\\$[^$]*\\$':'');$hi=microtime(true);parse_str($_COOKIE["adminer_export"],$ya);$kc=$b->dumpFormat();unset($kc["sql"]);while($G!=""){if(!$D&&preg_match("~^$oh*+DELIMITER\\s+(\\S+)~i",$G,$B)){$Vb=$B[1];$G=substr($G,strlen($B[0]));}else{preg_match('('.preg_quote($Vb)."\\s*|$Jf)",$G,$B,PREG_OFFSET_CAPTURE,$D);list($fd,$Xf)=$B[0];if(!$fd&&$hd&&!feof($hd))$G.=fread($hd,1e5);else{if(!$fd&&rtrim($G)=="")break;$D=$Xf+strlen($fd);if($fd&&rtrim($fd)!=$Vb){while(preg_match('('.($fd=='/*'?'\\*/':($fd=='['?']':(preg_match('~^-- |^#~',$fd)?"\n":preg_quote($fd)."|\\\\."))).'|$)s',$G,$B,PREG_OFFSET_CAPTURE,$D)){$Rg=$B[0][0];if(!$Rg&&$hd&&!feof($hd))$G.=fread($hd,1e5);else{$D=$B[0][1]+strlen($Rg);if($Rg[0]!="\\")break;}}}else{$tc=false;$ng=substr($G,0,$Xf);$ub++;$fg="<pre id='sql-$ub'><code class='jush-$y'>".$b->sqlCommandQuery($ng)."</code></pre>\n";if($y=="sqlite"&&preg_match("~^$oh*+ATTACH\\b~i",$ng,$B)){echo$fg,"<p class='error'>".lang(143)."\n";$yc[]=" <a href='#sql-$ub'>$ub</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$fg;ob_flush();flush();}$vh=microtime(true);if($g->multi_query($ng)&&is_object($h)&&preg_match("~^$oh*+USE\\b~i",$ng))$h->query($ng);do{$H=$g->store_result();if($g->error){echo($_POST["only_errors"]?$fg:""),"<p class='error'>".lang(144).($g->errno?" ($g->errno)":"").": ".error()."\n";$yc[]=" <a href='#sql-$ub'>$ub</a>";if($_POST["error_stops"])break
2;}else{$Vh=" <span class='time'>(".format_time($vh).")</span>".(strlen($ng)<1000?" <a href='".h(ME)."sql=".urlencode(trim($ng))."'>".lang(10)."</a>":"");$_a=$g->affected_rows;$Ui=($_POST["only_errors"]?"":$n->warnings());$Vi="warnings-$ub";if($Ui)$Vh.=", <a href='#$Vi'>".lang(44)."</a>".script("qsl('a').onclick = partial(toggle, '$Vi');","");$Fc=null;$Gc="explain-$ub";if(is_object($H)){$_=$_POST["limit"];$xf=select($H,$h,array(),$_);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$af=$H->num_rows;echo"<p>".($af?($_&&$af>$_?lang(145,$_):"").lang(146,$af):""),$Vh;if($h&&preg_match("~^($oh|\\()*+SELECT\\b~i",$ng)&&($Fc=explain($h,$ng)))echo", <a href='#$Gc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$Gc');","");$u="export-$ub";echo", <a href='#$u'>".lang(71)."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."<span id='$u' class='hidden'>: ".html_select("output",$b->dumpOutput(),$ya["output"])." ".html_select("format",$kc,$ya["format"])."<input type='hidden' name='query' value='".h($ng)."'>"." <input type='submit' name='export' value='".lang(71)."'><input type='hidden' name='token' value='$fi'></span>\n"."</form>\n";}}else{if(preg_match("~^$oh*+(CREATE|DROP|ALTER)$oh++(DATABASE|SCHEMA)\\b~i",$ng)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h($g->info)."'>".lang(147,$_a)."$Vh\n";}echo($Ui?"<div id='$Vi' class='hidden'>\n$Ui</div>\n":"");if($Fc){echo"<div id='$Gc' class='hidden'>\n";select($Fc,$h,$xf);echo"</div>\n";}}$vh=microtime(true);}while($g->next_result());}$G=substr($G,$D);$D=0;}}}}if($tc)echo"<p class='message'>".lang(148)."\n";elseif($_POST["only_errors"]){echo"<p class='message'>".lang(149,$ub-count($yc))," <span class='time'>(".format_time($hi).")</span>\n";}elseif($yc&&$ub>1)echo"<p class='error'>".lang(144).": ".implode("",$yc)."\n";}else
echo"<p class='error'>".upload_error($G)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$Cc="<input type='submit' value='".lang(150)."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$ng=$_GET["sql"];if($_POST)$ng=$_POST["query"];elseif($_GET["history"]=="all")$ng=$vd;elseif($_GET["history"]!="")$ng=$vd[$_GET["history"]][0];echo"<p>";textarea("query",$ng,20);echo($_POST?"":script("qs('textarea').focus();")),"<p>$Cc\n",lang(151).": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{echo"<fieldset><legend>".lang(152)."</legend><div>",(ini_bool("file_uploads")?"SQL (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$Cc":lang(153)),"</div></fieldset>\n","<fieldset><legend>".lang(154)."</legend><div>",lang(155,"<code>".h($b->importServerPath()).(extension_loaded("zlib")?"[.gz]":"")."</code>"),' <input type="submit" name="webfile" value="'.lang(156).'">',"</div></fieldset>\n","<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])),lang(157))."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])),lang(158))."\n","<input type='hidden' name='token' value='$fi'>\n";if(!isset($_GET["import"])&&$vd){print_fieldset("history",lang(159),$_GET["history"]!="");for($X=end($vd);$X;$X=prev($vd)){$z=key($vd);list($ng,$Vh,$oc)=$X;echo'<a href="'.h(ME."sql=&history=$z").'">'.lang(10)."</a>"." <span class='time' title='".@date('Y-m-d',$Vh)."'>".@date("H:i:s",$Vh)."</span>"." <code class='jush-$y'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace('~^(#|-- ).*~m','',$ng)))),80,"</code>").($oc?" <span class='time'>($oc)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".lang(160)."'>\n","<a href='".h(ME."sql=&history=all")."'>".lang(161)."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$q=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$q):""):where($_GET,$q));$Bi=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($q
as$C=>$p){if(!isset($p["privileges"][$Bi?"update":"insert"])||$b->fieldName($p)=="")unset($q[$C]);}if($_POST&&!$o&&!isset($_GET["select"])){$te=$_POST["referer"];if($_POST["insert"])$te=($Bi?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$te))$te=ME."select=".urlencode($a);$x=indexes($a);$xi=unique_array($_GET["where"],$x);$qg="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($te,lang(162),$n->delete($a,$qg,!$xi));else{$O=array();foreach($q
as$C=>$p){$X=process_input($p);if($X!==false&&$X!==null)$O[idf_escape($C)]=$X;}if($Bi){if(!$O)redirect($te);queries_redirect($te,lang(163),$n->update($a,$O,$qg,!$xi));if(is_ajax()){page_headers();page_messages($o);exit;}}else{$H=$n->insert($a,$O);$ke=($H?last_id():0);queries_redirect($te,lang(164,($ke?" $ke":"")),$H);}}}$J=null;if($_POST["save"])$J=(array)$_POST["fields"];elseif($Z){$L=array();foreach($q
as$C=>$p){if(isset($p["privileges"]["select"])){$Ha=convert_field($p);if($_POST["clone"]&&$p["auto_increment"])$Ha="''";if($y=="sql"&&preg_match("~enum|set~",$p["type"]))$Ha="1*".idf_escape($C);$L[]=($Ha?"$Ha AS ":"").idf_escape($C);}}$J=array();if(!support("table"))$L=array("*");if($L){$H=$n->select($a,$L,array($Z),$L,array(),(isset($_GET["select"])?2:1));if(!$H)$o=error();else{$J=$H->fetch_assoc();if(!$J)$J=false;}if(isset($_GET["select"])&&(!$J||$H->fetch_assoc()))$J=null;}}if(!support("table")&&!$q){if(!$Z){$H=$n->select($a,array("*"),$Z,array("*"));$J=($H?$H->fetch_assoc():false);if(!$J)$J=array($n->primary=>"");}if($J){foreach($J
as$z=>$X){if(!$Z)$J[$z]=null;$q[$z]=array("field"=>$z,"null"=>($z!=$n->primary),"auto_increment"=>($z==$n->primary));}}}edit_form($a,$q,$J,$Bi);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Lf=array();foreach(array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$z)$Lf[$z]=$z;$yg=referencable_primary($a);$dd=array();foreach($yg
as$Gh=>$p)$dd[str_replace("`","``",$Gh)."`".str_replace("`","``",$p["field"])]=$Gh;$_f=array();$S=array();if($a!=""){$_f=fields($a);$S=table_status($a);if(!$S)$o=lang(9);}$J=$_POST;$J["fields"]=(array)$J["fields"];if($J["auto_increment_col"])$J["fields"][$J["auto_increment_col"]]["auto_increment"]=true;if($_POST&&!process_fields($J["fields"])&&!$o){if($_POST["drop"])queries_redirect(substr(ME,0,-1),lang(165),drop_tables(array($a)));else{$q=array();$Ea=array();$Gi=false;$bd=array();$zf=reset($_f);$Ba=" FIRST";foreach($J["fields"]as$z=>$p){$r=$dd[$p["type"]];$si=($r!==null?$yg[$r]:$p);if($p["field"]!=""){if(!$p["has_default"])$p["default"]=null;if($z==$J["auto_increment_col"])$p["auto_increment"]=true;$kg=process_field($p,$si);$Ea[]=array($p["orig"],$kg,$Ba);if($kg!=process_field($zf,$zf)){$q[]=array($p["orig"],$kg,$Ba);if($p["orig"]!=""||$Ba)$Gi=true;}if($r!==null)$bd[idf_escape($p["field"])]=($a!=""&&$y!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$dd[$p["type"]],'source'=>array($p["field"]),'target'=>array($si["field"]),'on_delete'=>$p["on_delete"],));$Ba=" AFTER ".idf_escape($p["field"]);}elseif($p["orig"]!=""){$Gi=true;$q[]=array($p["orig"]);}if($p["orig"]!=""){$zf=next($_f);if(!$zf)$Ba="";}}$Nf="";if($Lf[$J["partition_by"]]){$Of=array();if($J["partition_by"]=='RANGE'||$J["partition_by"]=='LIST'){foreach(array_filter($J["partition_names"])as$z=>$X){$Y=$J["partition_values"][$z];$Of[]="\n  PARTITION ".idf_escape($X)." VALUES ".($J["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$Nf.="\nPARTITION BY $J[partition_by]($J[partition])".($Of?" (".implode(",",$Of)."\n)":($J["partitions"]?" PARTITIONS ".(+$J["partitions"]):""));}elseif(support("partitioning")&&preg_match("~partitioned~",$S["Create_options"]))$Nf.="\nREMOVE PARTITIONING";$He=lang(166);if($a==""){cookie("adminer_engine",$J["Engine"]);$He=lang(167);}$C=trim($J["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($C),$He,alter_table($a,$C,($y=="sqlite"&&($Gi||$bd)?$Ea:$q),$bd,($J["Comment"]!=$S["Comment"]?$J["Comment"]:null),($J["Engine"]&&$J["Engine"]!=$S["Engine"]?$J["Engine"]:""),($J["Collation"]&&$J["Collation"]!=$S["Collation"]?$J["Collation"]:""),($J["Auto_increment"]!=""?number($J["Auto_increment"]):""),$Nf));}}page_header(($a!=""?lang(42):lang(72)),$o,array("table"=>$a),h($a));if(!$_POST){$J=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($ui["int"])?"int":(isset($ui["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$J=$S;$J["name"]=$a;$J["fields"]=array();if(!$_GET["auto_increment"])$J["Auto_increment"]="";foreach($_f
as$p){$p["has_default"]=isset($p["default"]);$J["fields"][]=$p;}if(support("partitioning")){$id="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($a);$H=$g->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $id ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");list($J["partition_by"],$J["partitions"],$J["partition"])=$H->fetch_row();$Of=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $id AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$Of[""]="";$J["partition_names"]=array_keys($Of);$J["partition_values"]=array_values($Of);}}}$qb=collations();$vc=engines();foreach($vc
as$uc){if(!strcasecmp($uc,$J["Engine"])){$J["Engine"]=$uc;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo
lang(168),': <input name="name" maxlength="64" value="',h($J["name"]),'" autocapitalize="off">
';if($a==""&&!$_POST)echo
script("focus(qs('#form')['name']);");echo($vc?"<select name='Engine'>".optionlist(array(""=>"(".lang(169).")")+$vc,$J["Engine"])."</select>".on_help("getTarget(event).value",1).script("qsl('select').onchange = helpClose;"):""),' ',($qb&&!preg_match("~sqlite|mssql~",$y)?html_select("Collation",array(""=>"(".lang(97).")")+$qb,$J["Collation"]):""),' <input type="submit" value="',lang(14),'">
';}echo'
';if(support("columns")){echo'<table cellspacing="0" id="edit-fields" class="nowrap">
';$wb=($_POST?$_POST["comments"]:$J["Comment"]!="");if(!$_POST&&!$wb){foreach($J["fields"]as$p){if($p["comment"]!=""){$wb=true;break;}}}edit_fields($J["fields"],$qb,"TABLE",$dd,$wb);echo'</table>
<p>
',lang(49),': <input type="number" name="Auto_increment" size="6" value="',h($J["Auto_increment"]),'">
',checkbox("defaults",1,true,lang(170),"columnShow(this.checked, 5)","jsonly");if(!$_POST["defaults"])echo
script("editingHideDefaults();");echo(support("comment")?"<label><input type='checkbox' name='comments' value='1' class='jsonly'".($wb?" checked":"").">".lang(48)."</label>".script("qsl('input').onclick = function () { columnShow(this.checked, 6); toggle('Comment'); if (this.checked) this.form['Comment'].focus(); };").' <input name="Comment" id="Comment" value="'.h($J["Comment"]).'" maxlength="'.(min_version(5.5)?2048:60).'"'.($wb?'':' class="hidden"').'>':''),'<p>
<input type="submit" value="',lang(14),'">
';}echo'
';if($a!=""){echo'<input type="submit" name="drop" value="',lang(123),'">',confirm(lang(171,$a));}if(support("partitioning")){$Mf=preg_match('~RANGE|LIST~',$J["partition_by"]);print_fieldset("partition",lang(172),$J["partition_by"]);echo'<p>
',"<select name='partition_by'>".optionlist(array(""=>"")+$Lf,$J["partition_by"])."</select>".on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($J["partition"]),'">)
',lang(173),': <input type="number" name="partitions" class="size',($Mf||!$J["partition_by"]?" hidden":""),'" value="',h($J["partitions"]),'">
<table cellspacing="0" id="partition-table"',($Mf?"":" class='hidden'"),'>
<thead><tr><th>',lang(174),'<th>',lang(175),'</thead>
';foreach($J["partition_names"]as$z=>$X){echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($z==count($J["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($J["partition_values"][$z]).'">';}echo'</table>
</div></fieldset>
';}echo'<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$Ed=array("PRIMARY","UNIQUE","INDEX");$S=table_status($a,true);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$S["Engine"]))$Ed[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$S["Engine"]))$Ed[]="SPATIAL";$x=indexes($a);$dg=array();if($y=="mongo"){$dg=$x["_id_"];unset($Ed[0]);unset($x["_id_"]);}$J=$_POST;if($_POST&&!$o&&!$_POST["add"]&&!$_POST["drop_col"]){$c=array();foreach($J["indexes"]as$w){$C=$w["name"];if(in_array($w["type"],$Ed)){$e=array();$qe=array();$Xb=array();$O=array();ksort($w["columns"]);foreach($w["columns"]as$z=>$d){if($d!=""){$pe=$w["lengths"][$z];$Wb=$w["descs"][$z];$O[]=idf_escape($d).($pe?"(".(+$pe).")":"").($Wb?" DESC":"");$e[]=$d;$qe[]=($pe?$pe:null);$Xb[]=$Wb;}}if($e){$Dc=$x[$C];if($Dc){ksort($Dc["columns"]);ksort($Dc["lengths"]);ksort($Dc["descs"]);if($w["type"]==$Dc["type"]&&array_values($Dc["columns"])===$e&&(!$Dc["lengths"]||array_values($Dc["lengths"])===$qe)&&array_values($Dc["descs"])===$Xb){unset($x[$C]);continue;}}$c[]=array($w["type"],$C,$O);}}}foreach($x
as$C=>$Dc)$c[]=array($Dc["type"],$C,"DROP");if(!$c)redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),lang(176),alter_indexes($a,$c));}page_header(lang(128),$o,array("table"=>$a),h($a));$q=array_keys(fields($a));if($_POST["add"]){foreach($J["indexes"]as$z=>$w){if($w["columns"][count($w["columns"])]!="")$J["indexes"][$z]["columns"][]="";}$w=end($J["indexes"]);if($w["type"]||array_filter($w["columns"],'strlen'))$J["indexes"][]=array("columns"=>array(1=>""));}if(!$J){foreach($x
as$z=>$w){$x[$z]["name"]=$z;$x[$z]["columns"][]="";}$x[]=array("columns"=>array(1=>""));$J["indexes"]=$x;}echo'
<form action="" method="post">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">',lang(177),'<th><input type="submit" class="wayoff">',lang(178),'<th id="label-name">',lang(179);?>
<th><noscript><input type='image' class='icon' name='add[0]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.6.1") . "' alt='+' title='<?php echo
lang(104),'\'></noscript>&nbsp;
</thead>
';if($dg){echo"<tr><td>PRIMARY<td>";foreach($dg["columns"]as$z=>$d){echo
select_input(" disabled",$q,$d),"<label><input disabled type='checkbox'>".lang(57)."</label> ";}echo"<td><td>\n";}$Xd=1;foreach($J["indexes"]as$w){if(!$_POST["drop_col"]||$Xd!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$Xd][type]",array(-1=>"")+$Ed,$w["type"],($Xd==count($J["indexes"])?"indexesAddRow.call(this);":1),"label-type"),"<td>";ksort($w["columns"]);$t=1;foreach($w["columns"]as$z=>$d){echo"<span>".select_input(" name='indexes[$Xd][columns][$t]' title='".lang(46)."'",($q?array_combine($q,$q):$q),$d,"partial(".($t==count($w["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape($y=="sql"?"":$_GET["indexes"]."_")."')"),($y=="sql"||$y=="mssql"?"<input type='number' name='indexes[$Xd][lengths][$t]' class='size' value='".h($w["lengths"][$z])."' title='".lang(102)."'>":""),($y!="sql"?checkbox("indexes[$Xd][descs][$t]",1,$w["descs"][$z],lang(57)):"")," </span>";$t++;}echo"<td><input name='indexes[$Xd][name]' value='".h($w["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$Xd]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.6.1")."' alt='x' title='".lang(107)."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$Xd++;}echo'</table>
<p>
<input type="submit" value="',lang(14),'">
<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["database"])){$J=$_POST;if($_POST&&!$o&&!isset($_POST["add_x"])){$C=trim($J["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),lang(180),drop_databases(array(DB)));}elseif(DB!==$C){if(DB!=""){$_GET["db"]=$C;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($C),lang(181),rename_database($C,$J["collation"]));}else{$l=explode("\n",str_replace("\r","",$C));$Ah=true;$je="";foreach($l
as$m){if(count($l)==1||$m!=""){if(!create_database($m,$J["collation"]))$Ah=false;$je=$m;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($je),lang(182),$Ah);}}else{if(!$J["collation"])redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($C).(preg_match('~^[a-z0-9_]+$~i',$J["collation"])?" COLLATE $J[collation]":""),substr(ME,0,-1),lang(183));}}page_header(DB!=""?lang(65):lang(111),$o,array(),h(DB));$qb=collations();$C=DB;if($_POST)$C=$J["name"];elseif(DB!="")$J["collation"]=db_collation(DB,$qb);elseif($y=="sql"){foreach(get_vals("SHOW GRANTS")as$kd){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\\.\\*)?~',$kd,$B)&&$B[1]){$C=stripcslashes(idf_unescape("`$B[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($C,"\n")?'<textarea id="name" name="name" rows="10" cols="40">'.h($C).'</textarea><br>':'<input name="name" id="name" value="'.h($C).'" maxlength="64" autocapitalize="off">')."\n".($qb?html_select("collation",array(""=>"(".lang(97).")")+$qb,$J["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",'mssql'=>"ms187963.aspx",)):""),script("focus(qs('#name'));"),'<input type="submit" value="',lang(14),'">
';if(DB!="")echo"<input type='submit' name='drop' value='".lang(123)."'>".confirm(lang(171,DB))."\n";elseif(!$_POST["add_x"]&&$_GET["db"]=="")echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.6.1")."' alt='+' title='".lang(104)."'>\n";echo'<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["scheme"])){$J=$_POST;if($_POST&&!$o){$A=preg_replace('~ns=[^&]*&~','',ME)."ns=";if($_POST["drop"])query_redirect("DROP SCHEMA ".idf_escape($_GET["ns"]),$A,lang(184));else{$C=trim($J["name"]);$A.=urlencode($C);if($_GET["ns"]=="")query_redirect("CREATE SCHEMA ".idf_escape($C),$A,lang(185));elseif($_GET["ns"]!=$C)query_redirect("ALTER SCHEMA ".idf_escape($_GET["ns"])." RENAME TO ".idf_escape($C),$A,lang(186));else
redirect($A);}}page_header($_GET["ns"]!=""?lang(66):lang(67),$o);if(!$J)$J["name"]=$_GET["ns"];echo'
<form action="" method="post">
<p><input name="name" id="name" value="',h($J["name"]),'" autocapitalize="off">
',script("focus(qs('#name'));"),'<input type="submit" value="',lang(14),'">
';if($_GET["ns"]!="")echo"<input type='submit' name='drop' value='".lang(123)."'>".confirm(lang(171,$_GET["ns"]))."\n";echo'<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["call"])){$da=($_GET["name"]?$_GET["name"]:$_GET["call"]);page_header(lang(187).": ".h($da),$o);$Ng=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Cd=array();$Df=array();foreach($Ng["fields"]as$t=>$p){if(substr($p["inout"],-3)=="OUT")$Df[$t]="@".idf_escape($p["field"])." AS ".idf_escape($p["field"]);if(!$p["inout"]||substr($p["inout"],0,2)=="IN")$Cd[]=$t;}if(!$o&&$_POST){$ab=array();foreach($Ng["fields"]as$z=>$p){if(in_array($z,$Cd)){$X=process_input($p);if($X===false)$X="''";if(isset($Df[$z]))$g->query("SET @".idf_escape($p["field"])." = $X");}$ab[]=(isset($Df[$z])?"@".idf_escape($p["field"]):$X);}$G=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ",$ab).")";$vh=microtime(true);$H=$g->multi_query($G);$_a=$g->affected_rows;echo$b->selectQuery($G,$vh,!$H);if(!$H)echo"<p class='error'>".error()."\n";else{$h=connect();if(is_object($h))$h->select_db(DB);do{$H=$g->store_result();if(is_object($H))select($H,$h);else
echo"<p class='message'>".lang(188,$_a)."\n";}while($g->next_result());if($Df)select($g->query("SELECT ".implode(", ",$Df)));}}echo'
<form action="" method="post">
';if($Cd){echo"<table cellspacing='0'>\n";foreach($Cd
as$z){$p=$Ng["fields"][$z];$C=$p["field"];echo"<tr><th>".$b->fieldName($p);$Y=$_POST["fields"][$C];if($Y!=""){if($p["type"]=="enum")$Y=+$Y;if($p["type"]=="set")$Y=array_sum($Y);}input($p,$Y,(string)$_POST["function"][$C]);echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="',lang(187),'">
<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$C=$_GET["name"];$J=$_POST;if($_POST&&!$o&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){$He=($_POST["drop"]?lang(189):($C!=""?lang(190):lang(191)));$te=ME."table=".urlencode($a);if(!$_POST["drop"]){$J["source"]=array_filter($J["source"],'strlen');ksort($J["source"]);$Oh=array();foreach($J["source"]as$z=>$X)$Oh[$z]=$J["target"][$z];$J["target"]=$Oh;}if($y=="sqlite")queries_redirect($te,$He,recreate_table($a,$a,array(),array(),array(" $C"=>($_POST["drop"]?"":" ".format_foreign_key($J)))));else{$c="ALTER TABLE ".table($a);$fc="\nDROP ".($y=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($C);if($_POST["drop"])query_redirect($c.$fc,$te,$He);else{query_redirect($c.($C!=""?"$fc,":"")."\nADD".format_foreign_key($J),$te,$He);$o=lang(192)."<br>$o";}}}page_header(lang(193),$o,array("table"=>$a),h($a));if($_POST){ksort($J["source"]);if($_POST["add"])$J["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$J["target"]=array();}elseif($C!=""){$dd=foreign_keys($a);$J=$dd[$C];$J["source"][]="";}else{$J["table"]=$a;$J["source"]=array("");}$nh=array_keys(fields($a));$Oh=($a===$J["table"]?$nh:array_keys(fields($J["table"])));$xg=array_keys(array_filter(table_status('',true),'fk_support'));echo'
<form action="" method="post">
<p>
';if($J["db"]==""&&$J["ns"]==""){echo
lang(194),':
',html_select("table",$xg,$J["table"],"this.form['change-js'].value = '1'; this.form.submit();"),'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="',lang(195),'"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">',lang(130),'<th id="label-target">',lang(131),'</thead>
';$Xd=0;foreach($J["source"]as$z=>$X){echo"<tr>","<td>".html_select("source[".(+$z)."]",array(-1=>"")+$nh,$X,($Xd==count($J["source"])-1?"foreignAddRow.call(this);":1),"label-source"),"<td>".html_select("target[".(+$z)."]",$Oh,$J["target"][$z],1,"label-target");$Xd++;}echo'</table>
<p>
',lang(99),': ',html_select("on_delete",array(-1=>"")+explode("|",$kf),$J["on_delete"]),' ',lang(98),': ',html_select("on_update",array(-1=>"")+explode("|",$kf),$J["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",'pgsql'=>"sql-createtable.html#SQL-CREATETABLE-REFERENCES",'mssql'=>"ms174979.aspx",'oracle'=>"clauses002.htm#sthref2903",)),'<p>
<input type="submit" value="',lang(14),'">
<noscript><p><input type="submit" name="add" value="',lang(196),'"></noscript>
';}if($C!=""){echo'<input type="submit" name="drop" value="',lang(123),'">',confirm(lang(171,$C));}echo'<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$J=$_POST;$Af="VIEW";if($y=="pgsql"&&$a!=""){$P=table_status($a);$Af=strtoupper($P["Engine"]);}if($_POST&&!$o){$C=trim($J["name"]);$Ha=" AS\n$J[select]";$te=ME."table=".urlencode($C);$He=lang(197);$U=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$C&&$y!="sqlite"&&$U=="VIEW"&&$Af=="VIEW")query_redirect(($y=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($C).$Ha,$te,$He);else{$Qh=$C."_adminer_".uniqid();drop_create("DROP $Af ".table($a),"CREATE $U ".table($C).$Ha,"DROP $U ".table($C),"CREATE $U ".table($Qh).$Ha,"DROP $U ".table($Qh),($_POST["drop"]?substr(ME,0,-1):$te),lang(198),$He,lang(199),$a,$C);}}if(!$_POST&&$a!=""){$J=view($a);$J["name"]=$a;$J["materialized"]=($Af!="VIEW");if(!$o)$o=error();}page_header(($a!=""?lang(41):lang(200)),$o,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>',lang(179),': <input name="name" value="',h($J["name"]),'" maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$J["materialized"],lang(125)):""),'<p>';textarea("select",$J["select"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($a!=""){echo'<input type="submit" name="drop" value="',lang(123),'">',confirm(lang(171,$a));}echo'<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$Pd=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$xh=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$J=$_POST;if($_POST&&!$o){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),lang(201));elseif(in_array($J["INTERVAL_FIELD"],$Pd)&&isset($xh[$J["STATUS"]])){$Sg="\nON SCHEDULE ".($J["INTERVAL_VALUE"]?"EVERY ".q($J["INTERVAL_VALUE"])." $J[INTERVAL_FIELD]".($J["STARTS"]?" STARTS ".q($J["STARTS"]):"").($J["ENDS"]?" ENDS ".q($J["ENDS"]):""):"AT ".q($J["STARTS"]))." ON COMPLETION".($J["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?lang(202):lang(203)),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$Sg.($aa!=$J["EVENT_NAME"]?"\nRENAME TO ".idf_escape($J["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($J["EVENT_NAME"]).$Sg)."\n".$xh[$J["STATUS"]]." COMMENT ".q($J["EVENT_COMMENT"]).rtrim(" DO\n$J[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?lang(204).": ".h($aa):lang(205)),$o);if(!$J&&$aa!=""){$K=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$J=reset($K);}echo'
<form action="" method="post">
<table cellspacing="0">
<tr><th>',lang(179),'<td><input name="EVENT_NAME" value="',h($J["EVENT_NAME"]),'" maxlength="64" autocapitalize="off">
<tr><th title="datetime">',lang(206),'<td><input name="STARTS" value="',h("$J[EXECUTE_AT]$J[STARTS]"),'">
<tr><th title="datetime">',lang(207),'<td><input name="ENDS" value="',h($J["ENDS"]),'">
<tr><th>',lang(208),'<td><input type="number" name="INTERVAL_VALUE" value="',h($J["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$Pd,$J["INTERVAL_FIELD"]),'<tr><th>',lang(114),'<td>',html_select("STATUS",$xh,$J["STATUS"]),'<tr><th>',lang(48),'<td><input name="EVENT_COMMENT" value="',h($J["EVENT_COMMENT"]),'" maxlength="64">
<tr><th>&nbsp;<td>',checkbox("ON_COMPLETION","PRESERVE",$J["ON_COMPLETION"]=="PRESERVE",lang(209)),'</table>
<p>';textarea("EVENT_DEFINITION",$J["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($aa!=""){echo'<input type="submit" name="drop" value="',lang(123),'">',confirm(lang(171,$aa));}echo'<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["procedure"])){$da=($_GET["name"]?$_GET["name"]:$_GET["procedure"]);$Ng=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$J=$_POST;$J["fields"]=(array)$J["fields"];if($_POST&&!process_fields($J["fields"])&&!$o){$yf=routine($_GET["procedure"],$Ng);$Qh="$J[name]_adminer_".uniqid();drop_create("DROP $Ng ".routine_id($da,$yf),create_routine($Ng,$J),"DROP $Ng ".routine_id($J["name"],$J),create_routine($Ng,array("name"=>$Qh)+$J),"DROP $Ng ".routine_id($Qh,$J),substr(ME,0,-1),lang(210),lang(211),lang(212),$da,$J["name"]);}page_header(($da!=""?(isset($_GET["function"])?lang(213):lang(214)).": ".h($da):(isset($_GET["function"])?lang(215):lang(216))),$o);if(!$_POST&&$da!=""){$J=routine($_GET["procedure"],$Ng);$J["name"]=$da;}$qb=get_vals("SHOW CHARACTER SET");sort($qb);$Og=routine_languages();echo'
<form action="" method="post" id="form">
<p>',lang(179),': <input name="name" value="',h($J["name"]),'" maxlength="64" autocapitalize="off">
',($Og?lang(19).": ".html_select("language",$Og,$J["language"])."\n":""),'<input type="submit" value="',lang(14),'">
<table cellspacing="0" class="nowrap">
';edit_fields($J["fields"],$qb,$Ng);if(isset($_GET["function"])){echo"<tr><td>".lang(217);edit_type("returns",$J["returns"],$qb,array(),($y=="pgsql"?array("void","trigger"):array()));}echo'</table>
<p>';textarea("definition",$J["definition"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($da!=""){echo'<input type="submit" name="drop" value="',lang(123),'">',confirm(lang(171,$da));}echo'<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["sequence"])){$fa=$_GET["sequence"];$J=$_POST;if($_POST&&!$o){$A=substr(ME,0,-1);$C=trim($J["name"]);if($_POST["drop"])query_redirect("DROP SEQUENCE ".idf_escape($fa),$A,lang(218));elseif($fa=="")query_redirect("CREATE SEQUENCE ".idf_escape($C),$A,lang(219));elseif($fa!=$C)query_redirect("ALTER SEQUENCE ".idf_escape($fa)." RENAME TO ".idf_escape($C),$A,lang(220));else
redirect($A);}page_header($fa!=""?lang(221).": ".h($fa):lang(222),$o);if(!$J)$J["name"]=$fa;echo'
<form action="" method="post">
<p><input name="name" value="',h($J["name"]),'" autocapitalize="off">
<input type="submit" value="',lang(14),'">
';if($fa!="")echo"<input type='submit' name='drop' value='".lang(123)."'>".confirm(lang(171,$fa))."\n";echo'<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["type"])){$ga=$_GET["type"];$J=$_POST;if($_POST&&!$o){$A=substr(ME,0,-1);if($_POST["drop"])query_redirect("DROP TYPE ".idf_escape($ga),$A,lang(223));else
query_redirect("CREATE TYPE ".idf_escape(trim($J["name"]))." $J[as]",$A,lang(224));}page_header($ga!=""?lang(225).": ".h($ga):lang(226),$o);if(!$J)$J["as"]="AS ";echo'
<form action="" method="post">
<p>
';if($ga!="")echo"<input type='submit' name='drop' value='".lang(123)."'>".confirm(lang(171,$ga))."\n";else{echo"<input name='name' value='".h($J['name'])."' autocapitalize='off'>\n";textarea("as",$J["as"]);echo"<p><input type='submit' value='".lang(14)."'>\n";}echo'<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$C=$_GET["name"];$qi=trigger_options();$J=(array)trigger($C)+array("Trigger"=>$a."_bi");if($_POST){if(!$o&&in_array($_POST["Timing"],$qi["Timing"])&&in_array($_POST["Event"],$qi["Event"])&&in_array($_POST["Type"],$qi["Type"])){$jf=" ON ".table($a);$fc="DROP TRIGGER ".idf_escape($C).($y=="pgsql"?$jf:"");$te=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($fc,$te,lang(227));else{if($C!="")queries($fc);queries_redirect($te,($C!=""?lang(228):lang(229)),queries(create_trigger($jf,$_POST)));if($C!="")queries(create_trigger($jf,$J+array("Type"=>reset($qi["Type"]))));}}$J=$_POST;}page_header(($C!=""?lang(230).": ".h($C):lang(231)),$o,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table cellspacing="0">
<tr><th>',lang(232),'<td>',html_select("Timing",$qi["Timing"],$J["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>',lang(233),'<td>',html_select("Event",$qi["Event"],$J["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$qi["Event"])?" <input name='Of' value='".h($J["Of"])."' class='hidden'>":""),'<tr><th>',lang(47),'<td>',html_select("Type",$qi["Type"],$J["Type"]),'</table>
<p>',lang(179),': <input name="Trigger" value="',h($J["Trigger"]),'" maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$J["Statement"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($C!=""){echo'<input type="submit" name="drop" value="',lang(123),'">',confirm(lang(171,$C));}echo'<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["user"])){$ha=$_GET["user"];$ig=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$J){foreach(explode(",",($J["Privilege"]=="Grant option"?"":$J["Context"]))as$Bb)$ig[$Bb][$J["Privilege"]]=$J["Comment"];}$ig["Server Admin"]+=$ig["File access on server"];$ig["Databases"]["Create routine"]=$ig["Procedures"]["Create routine"];unset($ig["Procedures"]["Create routine"]);$ig["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$ig["Columns"][$X]=$ig["Tables"][$X];unset($ig["Server Admin"]["Usage"]);foreach($ig["Tables"]as$z=>$X)unset($ig["Databases"][$z]);$Ue=array();if($_POST){foreach($_POST["objects"]as$z=>$X)$Ue[$X]=(array)$Ue[$X]+(array)$_POST["grants"][$z];}$ld=array();$hf="";if(isset($_GET["host"])&&($H=$g->query("SHOW GRANTS FOR ".q($ha)."@".q($_GET["host"])))){while($J=$H->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$J[0],$B)&&preg_match_all('~ *([^(,]*[^ ,(])( *\\([^)]+\\))?~',$B[1],$_e,PREG_SET_ORDER)){foreach($_e
as$X){if($X[1]!="USAGE")$ld["$B[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$J[0]))$ld["$B[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$J[0],$B))$hf=$B[1];}}if($_POST&&!$o){$if=(isset($_GET["host"])?q($ha)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $if",ME."privileges=",lang(234));else{$We=q($_POST["user"])."@".q($_POST["host"]);$Qf=$_POST["pass"];if($Qf!=''&&!$_POST["hashed"]){$Qf=$g->result("SELECT PASSWORD(".q($Qf).")");$o=!$Qf;}$Gb=false;if(!$o){if($if!=$We){$Gb=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $We IDENTIFIED BY PASSWORD ".q($Qf));$o=!$Gb;}elseif($Qf!=$hf)queries("SET PASSWORD FOR $We = ".q($Qf));}if(!$o){$Kg=array();foreach($Ue
as$cf=>$kd){if(isset($_GET["grant"]))$kd=array_filter($kd);$kd=array_keys($kd);if(isset($_GET["grant"]))$Kg=array_diff(array_keys(array_filter($Ue[$cf],'strlen')),$kd);elseif($if==$We){$ff=array_keys((array)$ld[$cf]);$Kg=array_diff($ff,$kd);$kd=array_diff($kd,$ff);unset($ld[$cf]);}if(preg_match('~^(.+)\\s*(\\(.*\\))?$~U',$cf,$B)&&(!grant("REVOKE",$Kg,$B[2]," ON $B[1] FROM $We")||!grant("GRANT",$kd,$B[2]," ON $B[1] TO $We"))){$o=true;break;}}}if(!$o&&isset($_GET["host"])){if($if!=$We)queries("DROP USER $if");elseif(!isset($_GET["grant"])){foreach($ld
as$cf=>$Kg){if(preg_match('~^(.+)(\\(.*\\))?$~U',$cf,$B))grant("REVOKE",array_keys($Kg),$B[2]," ON $B[1] FROM $We");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?lang(235):lang(236)),!$o);if($Gb)$g->query("DROP USER $We");}}page_header((isset($_GET["host"])?lang(33).": ".h("$ha@$_GET[host]"):lang(142)),$o,array("privileges"=>array('',lang(69))));if($_POST){$J=$_POST;$ld=$Ue;}else{$J=$_GET+array("host"=>$g->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$J["pass"]=$hf;if($hf!="")$J["hashed"]=true;$ld[(DB==""||$ld?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table cellspacing="0">
<tr><th>',lang(32),'<td><input name="host" maxlength="60" value="',h($J["host"]),'" autocapitalize="off">
<tr><th>',lang(33),'<td><input name="user" maxlength="16" value="',h($J["user"]),'" autocapitalize="off">
<tr><th>',lang(34),'<td><input name="pass" id="pass" value="',h($J["pass"]),'" autocomplete="new-password">
';if(!$J["hashed"])echo
script("typePassword(qs('#pass'));");echo
checkbox("hashed",1,$J["hashed"],lang(237),"typePassword(this.form['pass'], this.checked);"),'</table>

';echo"<table cellspacing='0'>\n","<thead><tr><th colspan='2'>".lang(69).doc_link(array('sql'=>"grant.html#priv_level"));$t=0;foreach($ld
as$cf=>$kd){echo'<th>'.($cf!="*.*"?"<input name='objects[$t]' value='".h($cf)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");$t++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>lang(32),"Databases"=>lang(35),"Tables"=>lang(127),"Columns"=>lang(46),"Procedures"=>lang(238),)as$Bb=>$Wb){foreach((array)$ig[$Bb]as$hg=>$vb){echo"<tr".odd()."><td".($Wb?">$Wb<td":" colspan='2'").' lang="en" title="'.h($vb).'">'.h($hg);$t=0;foreach($ld
as$cf=>$kd){$C="'grants[$t][".h(strtoupper($hg))."]'";$Y=$kd[strtoupper($hg)];if($Bb=="Server Admin"&&$cf!=(isset($ld["*.*"])?"*.*":".*"))echo"<td>&nbsp;";elseif(isset($_GET["grant"]))echo"<td><select name=$C><option><option value='1'".($Y?" selected":"").">".lang(239)."<option value='0'".($Y=="0"?" selected":"").">".lang(240)."</select>";else{echo"<td align='center'><label class='block'>","<input type='checkbox' name=$C value='1'".($Y?" checked":"").($hg=="All privileges"?" id='grants-$t-all'>":">".($hg=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))),"</label>";}$t++;}}}echo"</table>\n",'<p>
<input type="submit" value="',lang(14),'">
';if(isset($_GET["host"])){echo'<input type="submit" name="drop" value="',lang(123),'">',confirm(lang(171,"$ha@$_GET[host]"));}echo'<input type="hidden" name="token" value="',$fi,'">
</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")&&$_POST&&!$o){$ee=0;foreach((array)$_POST["kill"]as$X){if(kill_process($X))$ee++;}queries_redirect(ME."processlist=",lang(241,$ee),$ee||!$_POST["kill"]);}page_header(lang(112),$o);echo'
<form action="" method="post">
<table cellspacing="0" class="nowrap checkable">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$t=-1;foreach(process_list()as$t=>$J){if(!$t){echo"<thead><tr lang='en'>".(support("kill")?"<th>&nbsp;":"");foreach($J
as$z=>$X)echo"<th>$z".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($z),'pgsql'=>"monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",'oracle'=>"../b14237/dynviews_2088.htm",));echo"</thead>\n";}echo"<tr".odd().">".(support("kill")?"<td>".checkbox("kill[]",$J[$y=="sql"?"Id":"pid"],0):"");foreach($J
as$z=>$X)echo"<td>".(($y=="sql"&&$z=="Info"&&preg_match("~Query|Killed~",$J["Command"])&&$X!="")||($y=="pgsql"&&$z=="current_query"&&$X!="<IDLE>")||($y=="oracle"&&$z=="sql_text"&&$X!="")?"<code class='jush-$y'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($J["db"]!=""?"db=".urlencode($J["db"])."&":"")."sql=".urlencode($X)).'">'.lang(242).'</a>':nbsp($X));echo"\n";}echo'</table>
<p>
';if(support("kill")){echo($t+1)."/".lang(243,max_connections()),"<p><input type='submit' value='".lang(244)."'>\n";}echo'<input type="hidden" name="token" value="',$fi,'">
</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$S=table_status1($a);$x=indexes($a);$q=fields($a);$dd=column_foreign_keys($a);$ef=$S["Oid"];parse_str($_COOKIE["adminer_import"],$za);$Lg=array();$e=array();$Uh=null;foreach($q
as$z=>$p){$C=$b->fieldName($p);if(isset($p["privileges"]["select"])&&$C!=""){$e[$z]=html_entity_decode(strip_tags($C),ENT_QUOTES);if(is_shortable($p))$Uh=$b->selectLengthProcess();}$Lg+=$p["privileges"];}list($L,$md)=$b->selectColumnsProcess($e,$x);$Td=count($md)<count($L);$Z=$b->selectSearchProcess($q,$x);$uf=$b->selectOrderProcess($q,$x);$_=$b->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$yi=>$J){$Ha=convert_field($q[key($J)]);$L=array($Ha?$Ha:idf_escape(key($J)));$Z[]=where_check($yi,$q);$I=$n->select($a,$L,$Z,$L);if($I)echo
reset($I->fetch_row());}exit;}$dg=$_i=null;foreach($x
as$w){if($w["type"]=="PRIMARY"){$dg=array_flip($w["columns"]);$_i=($L?$dg:array());foreach($_i
as$z=>$X){if(in_array(idf_escape($z),$L))unset($_i[$z]);}break;}}if($ef&&!$dg){$dg=$_i=array($ef=>0);$x[]=array("type"=>"PRIMARY","columns"=>array($ef));}if($_POST&&!$o){$aj=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$gb=array();foreach($_POST["check"]as$db)$gb[]=where_check($db,$q);$aj[]="((".implode(") OR (",$gb)."))";}$aj=($aj?"\nWHERE ".implode(" AND ",$aj):"");if($_POST["export"]){cookie("adminer_import","output=".urlencode($_POST["output"])."&format=".urlencode($_POST["format"]));dump_headers($a);$b->dumpTable($a,"");$id=($L?implode(", ",$L):"*").convert_fields($e,$q,$L)."\nFROM ".table($a);$od=($md&&$Td?"\nGROUP BY ".implode(", ",$md):"").($uf?"\nORDER BY ".implode(", ",$uf):"");if(!is_array($_POST["check"])||$dg)$G="SELECT $id$aj$od";else{$wi=array();foreach($_POST["check"]as$X)$wi[]="(SELECT".limit($id,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$q).$od,1).")";$G=implode(" UNION ALL ",$wi);}$b->dumpData($a,"table",$G);exit;}if(!$b->selectEmailProcess($Z,$dd)){if($_POST["save"]||$_POST["delete"]){$H=true;$_a=0;$O=array();if(!$_POST["delete"]){foreach($e
as$C=>$X){$X=process_input($q[$C]);if($X!==null&&($_POST["clone"]||$X!==false))$O[idf_escape($C)]=($X!==false?$X:idf_escape($C));}}if($_POST["delete"]||$O){if($_POST["clone"])$G="INTO ".table($a)." (".implode(", ",array_keys($O)).")\nSELECT ".implode(", ",$O)."\nFROM ".table($a);if($_POST["all"]||($dg&&is_array($_POST["check"]))||$Td){$H=($_POST["delete"]?$n->delete($a,$aj):($_POST["clone"]?queries("INSERT $G$aj"):$n->update($a,$O,$aj)));$_a=$g->affected_rows;}else{foreach((array)$_POST["check"]as$X){$Wi="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$q);$H=($_POST["delete"]?$n->delete($a,$Wi,1):($_POST["clone"]?queries("INSERT".limit1($a,$G,$Wi)):$n->update($a,$O,$Wi,1)));if(!$H)break;$_a+=$g->affected_rows;}}}$He=lang(245,$_a);if($_POST["clone"]&&$H&&$_a==1){$ke=last_id();if($ke)$He=lang(164," $ke");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$He,$H);if(!$_POST["delete"]){edit_form($a,$q,(array)$_POST["fields"],!$_POST["clone"]);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$o=lang(246);else{$H=true;$_a=0;foreach($_POST["val"]as$yi=>$J){$O=array();foreach($J
as$z=>$X){$z=bracket_escape($z,1);$O[idf_escape($z)]=(preg_match('~char|text~',$q[$z]["type"])||$X!=""?$b->processInput($q[$z],$X):"NULL");}$H=$n->update($a,$O," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($yi,$q),!$Td&&!$dg," ");if(!$H)break;$_a+=$g->affected_rows;}queries_redirect(remove_from_uri(),lang(245,$_a),$H);}}elseif(!is_string($Tc=get_file("csv_file",true)))$o=upload_error($Tc);elseif(!preg_match('~~u',$Tc))$o=lang(247);else{cookie("adminer_import","output=".urlencode($za["output"])."&format=".urlencode($_POST["separator"]));$H=true;$sb=array_keys($q);preg_match_all('~(?>"[^"]*"|[^"\\r\\n]+)+~',$Tc,$_e);$_a=count($_e[0]);$n->begin();$M=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$K=array();foreach($_e[0]as$z=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$M]*)$M~",$X.$M,$Ae);if(!$z&&!array_diff($Ae[1],$sb)){$sb=$Ae[1];$_a--;}else{$O=array();foreach($Ae[1]as$t=>$nb)$O[idf_escape($sb[$t])]=($nb==""&&$q[$sb[$t]]["null"]?"NULL":q(str_replace('""','"',preg_replace('~^"|"$~','',$nb))));$K[]=$O;}}$H=(!$K||$n->insertUpdate($a,$K,$dg));if($H)$H=$n->commit();queries_redirect(remove_from_uri("page"),lang(248,$_a),$H);$n->rollback();}}}$Gh=$b->tableName($S);if(is_ajax()){page_headers();ob_start();}else
page_header(lang(51).": $Gh",$o);$O=null;if(isset($Lg["insert"])||!support("table")){$O="";foreach((array)$_GET["where"]as$X){if($dd[$X["col"]]&&count($dd[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&!preg_match('~[_%]~',$X["val"]))))$O.="&set".urlencode("[".bracket_escape($X["col"])."]")."=".urlencode($X["val"]);}}$b->selectLinks($S,$O);if(!$e&&support("table"))echo"<p class='error'>".lang(249).($q?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):"");echo'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";$b->selectColumnsPrint($L,$e);$b->selectSearchPrint($Z,$e,$x);$b->selectOrderPrint($uf,$e,$x);$b->selectLimitPrint($_);$b->selectLengthPrint($Uh);$b->selectActionPrint($x);echo"</form>\n";$E=$_GET["page"];if($E=="last"){$gd=$g->result(count_rows($a,$Z,$Td,$md));$E=floor(max(0,$gd-1)/$_);}$Xg=$L;$nd=$md;if(!$Xg){$Xg[]="*";$Cb=convert_fields($e,$q,$L);if($Cb)$Xg[]=substr($Cb,2);}foreach($L
as$z=>$X){$p=$q[idf_unescape($X)];if($p&&($Ha=convert_field($p)))$Xg[$z]="$Ha AS $X";}if(!$Td&&$_i){foreach($_i
as$z=>$X){$Xg[]=idf_escape($z);if($nd)$nd[]=idf_escape($z);}}$H=$n->select($a,$Xg,$Z,$nd,$uf,$_,$E,true);if(!$H)echo"<p class='error'>".error()."\n";else{if($y=="mssql"&&$E)$H->seek($_*$E);$sc=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$K=array();while($J=$H->fetch_assoc()){if($E&&$y=="oracle")unset($J["RNUM"]);$K[]=$J;}if($_GET["page"]!="last"&&$_!=""&&$md&&$Td&&$y=="sql")$gd=$g->result(" SELECT FOUND_ROWS()");if(!$K)echo"<p class='message'>".lang(12)."\n";else{$Qa=$b->backwardKeys($a,$Gh);echo"<table id='table' cellspacing='0' class='nowrap checkable'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$md&&$L?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".lang(250)."</a>");$Te=array();$jd=array();reset($L);$sg=1;foreach($K[0]as$z=>$X){if(!isset($_i[$z])){$X=$_GET["columns"][key($L)];$p=$q[$L?($X?$X["col"]:current($L)):$z];$C=($p?$b->fieldName($p,$sg):($X["fun"]?"*":$z));if($C!=""){$sg++;$Te[$z]=$C;$d=idf_escape($z);$zd=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($z);$Wb="&desc%5B0%5D=1";echo"<th>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});",""),'<a href="'.h($zd.($uf[0]==$d||$uf[0]==$z||(!$uf&&$Td&&$md[0]==$d)?$Wb:'')).'">';echo
apply_sql_function($X["fun"],$C)."</a>";echo"<span class='column hidden'>","<a href='".h($zd.$Wb)."' title='".lang(57)."' class='text'> â†“</a>";if(!$X["fun"]){echo'<a href="#fieldset-search" title="'.lang(54).'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($z)."');");}echo"</span>";}$jd[$z]=$X["fun"];next($L);}}$qe=array();if($_GET["modify"]){foreach($K
as$J){foreach($J
as$z=>$X)$qe[$z]=max($qe[$z],min(40,strlen(utf8_decode($X))));}}echo($Qa?"<th>".lang(251):"")."</thead>\n";if(is_ajax()){if($_%2==1&&$E%2==1)odd();ob_end_clean();}foreach($b->rowDescriptions($K,$dd)as$Se=>$J){$xi=unique_array($K[$Se],$x);if(!$xi){$xi=array();foreach($K[$Se]as$z=>$X){if(!preg_match('~^(COUNT\\((\\*|(DISTINCT )?`(?:[^`]|``)+`)\\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\\(`(?:[^`]|``)+`\\))$~',$z))$xi[$z]=$X;}}$yi="";foreach($xi
as$z=>$X){if(($y=="sql"||$y=="pgsql")&&preg_match('~char|text|enum|set~',$q[$z]["type"])&&strlen($X)>64){$z=(strpos($z,'(')?$z:idf_escape($z));$z="MD5(".($y!='sql'||preg_match("~^utf8~",$q[$z]["collation"])?$z:"CONVERT($z USING ".charset($g).")").")";$X=md5($X);}$yi.="&".($X!==null?urlencode("where[".bracket_escape($z)."]")."=".urlencode($X):"null%5B%5D=".urlencode($z));}echo"<tr".odd().">".(!$md&&$L?"":"<td>".checkbox("check[]",substr($yi,1),in_array(substr($yi,1),(array)$_POST["check"])).($Td||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$yi)."' class='edit'>".lang(252)."</a>"));foreach($J
as$z=>$X){if(isset($Te[$z])){$p=$q[$z];$X=$n->value($X,$p);if($X!=""&&(!isset($sc[$z])||$sc[$z]!=""))$sc[$z]=(is_mail($X)?$Te[$z]:"");$A="";if(preg_match('~blob|bytea|raw|file~',$p["type"])&&$X!="")$A=ME.'download='.urlencode($a).'&field='.urlencode($z).$yi;if(!$A&&$X!==null){foreach((array)$dd[$z]as$r){if(count($dd[$z])==1||end($r["source"])==$z){$A="";foreach($r["source"]as$t=>$nh)$A.=where_link($t,$r["target"][$t],$K[$Se][$nh]);$A=($r["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\\1'.urlencode($r["db"]),ME):ME).'select='.urlencode($r["table"]).$A;if($r["ns"])$A=preg_replace('~([?&]ns=)[^&]+~','\\1'.urlencode($r["ns"]),$A);if(count($r["source"])==1)break;}}}if($z=="COUNT(*)"){$A=ME."select=".urlencode($a);$t=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$xi))$A.=where_link($t++,$W["col"],$W["val"],$W["op"]);}foreach($xi
as$Yd=>$W)$A.=where_link($t++,$Yd,$W);}$X=select_value($X,$A,$p,$Uh);$u=h("val[$yi][".bracket_escape($z)."]");$Y=$_POST["val"][$yi][bracket_escape($z)];$nc=!is_array($J[$z])&&is_utf8($X)&&$K[$Se][$z]==$J[$z]&&!$jd[$z];$Th=preg_match('~text|lob~',$p["type"]);if(($_GET["modify"]&&$nc)||$Y!==null){$qd=h($Y!==null?$Y:$J[$z]);echo"<td>".($Th?"<textarea name='$u' cols='30' rows='".(substr_count($J[$z],"\n")+1)."'>$qd</textarea>":"<input name='$u' value='$qd' size='$qe[$z]'>");}else{$ve=strpos($X,"<i>...</i>");echo"<td id='$u' data-text='".($ve?2:($Th?1:0))."'".($nc?"":" data-warning='".h(lang(253))."'").">$X</td>";}}}if($Qa)echo"<td>";$b->backwardKeysPrint($Qa,$K[$Se]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n";}echo"<div class='footer'>\n";if(($K||$E)&&!is_ajax()){echo"<p>\n";$Bc=true;if($_GET["page"]!="last"){if($_==""||(count($K)<$_&&($K||!$E)))$gd=($E?$E*$_:0)+count($K);elseif($y!="sql"||!$Td){$gd=($Td?false:found_rows($S,$Z));if($gd<max(1e4,2*($E+1)*$_))$gd=reset(slow_query(count_rows($a,$Z,$Td,$md)));else$Bc=false;}}if($_!=""&&($gd===false||$gd>$_||$E)){$Ce=($gd===false?$E+(count($K)>=$_?2:1):floor(($gd-1)/$_));if($y!="simpledb"){echo'<a href="'.h(remove_from_uri("page")).'">'.lang(254)."</a>:",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".lang(254)."', '".($E+1)."')); return false; };"),pagination(0,$E).($E>5?" ...":"");for($t=max(1,$E-4);$t<min($Ce,$E+5);$t++)echo
pagination($t,$E);if($Ce>0){echo($E+5<$Ce?" ...":""),($Bc&&$gd!==false?pagination($Ce,$E):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$Ce'>".lang(255)."</a>");}echo(($gd===false?count($K)+1:$gd-$E*$_)>$_?' <a href="'.h(remove_from_uri("page")."&page=".($E+1)).'" class="loadmore">'.lang(256).'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$_).", '".lang(257)."...');",""):'');}else{echo
lang(254).":",pagination(0,$E).($E>1?" ...":""),($E?pagination($E,$E):""),($Ce>$E?pagination($E+1,$E).($Ce>$E+1?" ...":""):"");}echo"\n";}echo($gd!==false?"(".($Bc?"":"~ ").lang(146,$gd).") ":"");$bc=($Bc?"":"~ ").$gd;echo
checkbox("all",1,0,lang(258),"var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$bc' : checked); selectCount('selected2', this.checked || !checked ? '$bc' : checked);")."\n";if($b->selectCommandPrint()){echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>',lang(250),'</legend><div>
<input type="submit" value="',lang(14),'"',($_GET["modify"]?'':' title="'.lang(246).'"'),'>
</div></fieldset>
<fieldset><legend>',lang(122),' <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="',lang(10),'">
<input type="submit" name="clone" value="',lang(242),'">
<input type="submit" name="delete" value="',lang(18),'">',confirm(),'</div></fieldset>
';}$ed=$b->dumpFormat();foreach((array)$_GET["columns"]as$d){if($d["fun"]){unset($ed['sql']);break;}}if($ed){print_fieldset("export",lang(71)." <span id='selected2'></span>");$Ef=$b->dumpOutput();echo($Ef?html_select("output",$Ef,$za["output"])." ":""),html_select("format",$ed,$za["format"])," <input type='submit' name='export' value='".lang(71)."'>\n","</div></fieldset>\n";}}if($b->selectImportPrint()){print_fieldset("import",lang(70),!$K);echo"<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$za["format"],1);echo" <input type='submit' name='import' value='".lang(70)."'>","</div></fieldset>\n";}$b->selectEmailPrint(array_filter($sc,'strlen'),$e);echo"<input type='hidden' name='token' value='$fi'>\n","</div>\n","</form>\n",(!$md&&$L?"":script("tableCheck();"));}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$P=isset($_GET["status"]);page_header($P?lang(114):lang(113));$Ni=($P?show_status():show_variables());if(!$Ni)echo"<p class='message'>".lang(12)."\n";else{echo"<table cellspacing='0'>\n";foreach($Ni
as$z=>$X){echo"<tr>","<th><code class='jush-".$y.($P?"status":"set")."'>".h($z)."</code>","<td>".nbsp($X);}echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$Dh=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$C=>$S){json_row("Comment-$C",nbsp($S["Comment"]));if(!is_view($S)){foreach(array("Engine","Collation")as$z)json_row("$z-$C",nbsp($S[$z]));foreach($Dh+array("Auto_increment"=>0,"Rows"=>0)as$z=>$X){if($S[$z]!=""){$X=format_number($S[$z]);json_row("$z-$C",($z=="Rows"&&$X&&$S["Engine"]==($qh=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($Dh[$z]))$Dh[$z]+=($S["Engine"]!="InnoDB"||$z!="Data_free"?$S[$z]:0);}elseif(array_key_exists($z,$S))json_row("$z-$C");}}}foreach($Dh
as$z=>$X)json_row("sum-$z",format_number($X));json_row("");}elseif($_GET["script"]=="kill")$g->query("KILL ".number($_POST["kill"]));elseif($_GET["script"]=="version"){$hd=file_open_lock(get_temp_dir()."/adminer.version");if($hd)file_write_unlock($hd,serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));}else{foreach(count_tables($b->databases())as$m=>$X){json_row("tables-$m",$X);json_row("size-$m",db_size($m));}json_row("");}exit;}else{$Mh=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($Mh&&!$o&&!$_POST["search"]){$H=true;$He="";if($y=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$H=truncate_tables($_POST["tables"]);$He=lang(259);}elseif($_POST["move"]){$H=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$He=lang(260);}elseif($_POST["copy"]){$H=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$He=lang(261);}elseif($_POST["drop"]){if($_POST["views"])$H=drop_views($_POST["views"]);if($H&&$_POST["tables"])$H=drop_tables($_POST["tables"]);$He=lang(262);}elseif($y!="sql"){$H=($y=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$He=lang(263);}elseif(!$_POST["tables"])$He=lang(9);elseif($H=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('idf_escape',$_POST["tables"])))){while($J=$H->fetch_assoc())$He.="<b>".h($J["Table"])."</b>: ".h($J["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$He,$H);}page_header(($_GET["ns"]==""?lang(35).": ".h(DB):lang(75).": ".h($_GET["ns"])),$o,true);if($b->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".lang(264)."</h3>\n";$Lh=tables_list();if(!$Lh)echo"<p class='message'>".lang(9)."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".lang(265)." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".lang(54)."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]="LIKE %%";search_tables();}}$cc=doc_link(array('sql'=>'show-table-status.html'));echo"<table cellspacing='0' class='nowrap checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.lang(127),'<td>'.lang(266).doc_link(array('sql'=>'storage-engines.html')),'<td>'.lang(118).doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.lang(267).$cc,'<td>'.lang(268).$cc,'<td>'.lang(269).$cc,'<td>'.lang(49).doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.lang(270).$cc,(support("comment")?'<td>'.lang(48).$cc:''),"</thead>\n";$T=0;foreach($Lh
as$C=>$U){$Qi=($U!==null&&!preg_match('~table~i',$U));$u=h("Table-".$C);echo'<tr'.odd().'><td>'.checkbox(($Qi?"views[]":"tables[]"),$C,in_array($C,$Mh,true),"","","",$u),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($C)."' title='".lang(40)."' id='$u'>".h($C).'</a>':h($C));if($Qi){echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($C).'" title="'.lang(41).'">'.(preg_match('~materialized~i',$U)?lang(125):lang(126)).'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($C).'" title="'.lang(39).'">?</a>';}else{foreach(array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",lang(42)),"Index_length"=>array("indexes",lang(129)),"Data_free"=>array("edit",lang(43)),"Auto_increment"=>array("auto_increment=1&create",lang(42)),"Rows"=>array("select",lang(39)),)as$z=>$A){$u=" id='$z-".h($C)."'";echo($A?"<td align='right'>".(support("table")||$z=="Rows"||(support("indexes")&&$z!="Data_length")?"<a href='".h(ME."$A[0]=").urlencode($C)."'$u title='$A[1]'>?</a>":"<span$u>?</span>"):"<td id='$z-".h($C)."'>&nbsp;");}$T++;}echo(support("comment")?"<td id='Comment-".h($C)."'>&nbsp;":"");}echo"<tr><td>&nbsp;<th>".lang(243,count($Lh)),"<td>".nbsp($y=="sql"?$g->result("SELECT @@storage_engine"):""),"<td>".nbsp(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$z)echo"<td align='right' id='sum-$z'>&nbsp;";echo"</table>\n";if(!information_schema(DB)){echo"<div class='footer'>\n";$Ki="<input type='submit' value='".lang(271)."'> ".on_help("'VACUUM'");$qf="<input type='submit' name='optimize' value='".lang(272)."'> ".on_help($y=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");echo"<fieldset><legend>".lang(122)." <span id='selected'></span></legend><div>".($y=="sqlite"?$Ki:($y=="pgsql"?$Ki.$qf:($y=="sql"?"<input type='submit' value='".lang(273)."'> ".on_help("'ANALYZE TABLE'").$qf."<input type='submit' name='check' value='".lang(274)."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".lang(275)."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".lang(276)."'> ".on_help($y=="sqlite"?"'DELETE'":"'TRUNCATE".($y=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".lang(123)."'>".on_help("'DROP TABLE'").confirm()."\n";$l=(support("scheme")?$b->schemas():$b->databases());if(count($l)!=1&&$y!="sqlite"){$m=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo"<p>".lang(277).": ",($l?html_select("target",$l,$m):'<input name="target" value="'.h($m).'" autocapitalize="off">')," <input type='submit' name='move' value='".lang(278)."'>",(support("copy")?" <input type='submit' name='copy' value='".lang(279)."'>":""),"\n";}echo"<input type='hidden' name='all' value=''>";echo
script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $T);":"")." }"),"<input type='hidden' name='token' value='$fi'>\n","</div></fieldset>\n","</div>\n";}echo"</form>\n",script("tableCheck();");}echo'<p class="links"><a href="'.h(ME).'create=">'.lang(72)."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.lang(200)."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".lang(139)."</h3>\n";$Pg=routines();if($Pg){echo"<table cellspacing='0'>\n",'<thead><tr><th>'.lang(179).'<td>'.lang(47).'<td>'.lang(217)."<td>&nbsp;</thead>\n";odd('');foreach($Pg
as$J){$C=($J["SPECIFIC_NAME"]==$J["ROUTINE_NAME"]?"":"&name=".urlencode($J["ROUTINE_NAME"]));echo'<tr'.odd().'>','<th><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($J["SPECIFIC_NAME"]).$C).'">'.h($J["ROUTINE_NAME"]).'</a>','<td>'.h($J["ROUTINE_TYPE"]),'<td>'.h($J["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($J["SPECIFIC_NAME"]).$C).'">'.lang(132)."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.lang(216).'</a>':'').'<a href="'.h(ME).'function=">'.lang(215)."</a>\n";}if(support("sequence")){echo"<h3 id='sequences'>".lang(280)."</h3>\n";$dh=get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");if($dh){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(179)."</thead>\n";odd('');foreach($dh
as$X)echo"<tr".odd()."><th><a href='".h(ME)."sequence=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."sequence='>".lang(222)."</a>\n";}if(support("type")){echo"<h3 id='user-types'>".lang(24)."</h3>\n";$Ii=types();if($Ii){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(179)."</thead>\n";odd('');foreach($Ii
as$X)echo"<tr".odd()."><th><a href='".h(ME)."type=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."type='>".lang(226)."</a>\n";}if(support("event")){echo"<h3 id='events'>".lang(140)."</h3>\n";$K=get_rows("SHOW EVENTS");if($K){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(179)."<td>".lang(281)."<td>".lang(206)."<td>".lang(207)."<td></thead>\n";foreach($K
as$J){echo"<tr>","<th>".h($J["Name"]),"<td>".($J["Execute at"]?lang(282)."<td>".$J["Execute at"]:lang(208)." ".$J["Interval value"]." ".$J["Interval field"]."<td>$J[Starts]"),"<td>$J[Ends]",'<td><a href="'.h(ME).'event='.urlencode($J["Name"]).'">'.lang(132).'</a>';}echo"</table>\n";$_c=$g->result("SELECT @@event_scheduler");if($_c&&$_c!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($_c)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.lang(205)."</a>\n";}if($Lh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}}}page_footer();