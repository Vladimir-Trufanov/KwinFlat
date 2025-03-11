// JavaScript Document

var reader = new FileReader();
 [1](https://xdan.ru/working-with-files-in-javascript-part-2-filereader.html&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;post=4146182_1772)
reader.onload = function(event) {
    var contents = event.target.result; [1](https://xdan.ru/working-with-files-in-javascript-part-2-filereader.html&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;post=4146182_1772)
    console.log("Ñמהונזטלמו פאיכא: " + contents); [1](https://xdan.ru/working-with-files-in-javascript-part-2-filereader.html&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;post=4146182_1772)
}; [1](https://xdan.ru/working-with-files-in-javascript-part-2-filereader.html&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;post=4146182_1772)
reader.onerror = function(event) {
    console.error("Ôאיכ םו למזוע בûעü ןנמקטעאם! ךמה " + event.target.error.code); [1](https://xdan.ru/working-with-files-in-javascript-part-2-filereader.html&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;post=4146182_1772)
}; [1](https://xdan.ru/working-with-files-in-javascript-part-2-filereader.html&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;post=4146182_1772)
reader.readAsText(file); [1](https://xdan.ru/working-with-files-in-javascript-part-2-filereader.html&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;post=4146182_1772)

