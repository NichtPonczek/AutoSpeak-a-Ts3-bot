echo "chose a language eng,pl or de"
read Arsch
case "$Arsch" in
  "pl") echo 'ustawiono polski?'
rm include/language_file/eng.txt
rm include/language_file/de.txt
echo true >> include/language_file/pl.txt
 ;;
  "eng") echo 'language set to english!'
rm include/language_file/pl.txt
rm include/language_file/de.txt
echo true >> include/language_file/eng.txt
;;
"de") echo 'Sprache auf Deutsch eingestelt ...'
rm include/language_file/pl.txt
rm include/language_file/de.txt
echo true >> include/language_file/de.txt
;;
  *) echo "no such language! valid languages are de=deutsch eng=english pl=polski"
esac
