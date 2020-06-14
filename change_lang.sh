echo "chose a language eng,pl or de"
read Arsch
case "$Arsch" in
  "pl") echo 'ustawiono polski?'
rm include/language_file/eng.txt
rm include/language_file/de.txt
rm include/congigs/language.php
echo true >> include/language_file/pl.txt
echo '<?php $config['bot_language'] = 'pl'; ?>' >> include/congigs/language.php
 ;;
  "eng") echo 'language set to english!'
rm include/language_file/pl.txt
rm include/language_file/de.txt
rm include/congigs/language.php
echo true >> include/language_file/eng.txt
echo '<?php $config['bot_language'] = 'eng'; ?>' >> include/congigs/language.php
;;
"de") echo 'Sprache auf Deutsch eingestelt ...'
rm include/language_file/pl.txt
rm include/language_file/de.txt
rm include/congigs/language.php
echo true >> include/language_file/de.txt
echo '<?php $config['bot_language'] = 'de'; ?>' >> include/congigs/language.php
;;
  *) echo "no such language! valid languages are de=deutsch eng=english pl=polski"
esac
