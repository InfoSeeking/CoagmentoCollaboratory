#a script to build the extension (until I can get it to work without having to upload every time)
rm coagmentoAddon.xpi
cd coagmentoAddon
zip -r coagmentoAddon.xpi *
mv coagmentoAddon.xpi ../
echo "Done"
