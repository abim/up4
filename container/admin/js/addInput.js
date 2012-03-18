function addInput(divName){
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "<label for='DynName[]'><span>Masukkan Tipe Pemeriksaan disini</span></label><p><input class='input' type='text'  id='DynName[]' name='DynName[]' size='50' /></p><br class='clear'/><span>Masukkan Hasil Pemeriksaan disini</span></label><p><textarea class='input'  cols='50' rows='2'  id='DynValue[]' name='DynValue[]'></textarea></p><br class='clear'/><hr>";
          document.getElementById(divName).appendChild(newdiv);
}

