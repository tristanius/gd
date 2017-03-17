<div id=""> 
    <script type="text/javascript">
        $(document).ready(function(){
            alert("test");
            dir = "http://localhost/app.termo_gd/index.php/test/init";
            $("form#test01").submit(function(e){
                e.preventDefault();                
                $.ajax({
                    url: dir,
                    datatype: "json",
                    type: "POST",
                    data:{ id:"1090422853", pass: "admin" },
                    success: function(data, stst, jqxhr){
                        alert( JSON.stringify(data));
                    },
                    error: function(jqxhr, stst, throws){
                        alert("error: "+throws);
                    }
                });
            });
        });
    </script>
    <form action="" id="test01" method="post">
        <legend><h3>test 01</h3></legend>
        <h4>inicio de sesion remoto</h4>

        <label>Usuario</label><input type="text" name="id" />
        <label>Password</label><input type="password" name="pass" />
        <input type="submit" />
    </form>
</div>
    