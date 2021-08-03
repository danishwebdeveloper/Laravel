@include('admin.layout.header')
<div class="body-content">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <b>Category</b>
                </div>
                <div class="card-body">
                    <ul class="menu-cat todo-list m-t ui-sortable" style="margin-top:0px;">
                        @php
                        $rows = \App\blogcats::orderby('title' , 'asc' )->get();
                        foreach($rows as $k=>$v){
                        $link = route('HomeUrl')."/".$v->slug."-1".$v->id;
                        echo "
                        <li style='cursor:pointer;'
                            data-id = '$v->id'
                            data-title = '$v->title'
                            data-type = 'category'
                            data-link = '$link'
                            class = 'menu-added'
                            >".ucwords($v->title)."
                        </li>";
                        }
                        @endphp
                    </ul>
                </div>
                <div class="card-header">
                    <b>Custom Links</b>
                </div>
                <div class="card-body">
                    <label>URL</label>
                    <input type="text" name="url" placeholder="http://" class="form-control"/> <br>
                    <label>Link Text</label>
                    <input type="text" name="text" class="form-control"/>
                    <div class="text-right">
                        <br>
                        <button name="add" class="btn btn-info menu-added" data-type="link">Add to Menu</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
           <div class="card">
                <form method="post" action="">
                @csrf
            <div class="card-header">
                <div class="pull-right">
                    <p class="m-b-lg"><b>Add items from the left column</b>.</p>
                </div>
            </div>
            <div class="card-body">
                @php
                    if (isset($_POST["save"])){
                        $data = $_POST["data"];
                        $arr = array(
                            "menu" => $data
                        );
                        $Options->insert($arr);
                        header("location:?menu");
                    }elseif(isset($_GET["sv"])){
                        echo msg("success", "Menu has been saved.");    
                    }
                @endphp
                
                <div class="dd" id="nestable">
                    <ol class="dd-list main-dd-list">
                        @php
                        function __has_children($arr = array()){
                        $r = false;
                        foreach($arr as $k=>$v){
                        if (isset($v["children"])){
                        $r = true;
                        }
                        }
                        return $r;
                        }
                        function __menu($data, $level = 1){
                        foreach($data as $k=>$v){
                        if (isset($v["children"])){
                        $link = $v["link"];
                        $title = $v["title"];
                        $type = $v["type"];
                        $class=(__has_children($v["children"]))?"main-menu-sub sub-1st sm-nowrap
                        " : "sm-nowrap";
                        echo "
                        <li class= 'dd-item'
                            data-type = '$type'
                            data-title = '$title'
                            data-link = '$link'
                            >
                            <div class='dd-handle'> $title
                                <span class='menu-del pull-right' data-id='x'>x</span>
                                <span class='type pull-right'>$type</span>
                            </div>
                            <ol class='dd-list'>";
                                __menu($v["children"], $level++);
                            echo "</ol>
                        </li>";
                        }else{
                        $link = $v["link"];
                        $title = $v["title"];
                        $type = $v["type"];
                        echo "
                        <li class= 'dd-item'
                            data-type = '$type'
                            data-title = '$title'
                            data-link = '$link'
                            >
                            <div class='dd-handle'> $title
                                <span class='menu-del pull-right' data-id='x'>x</span>
                                <span class='type pull-right'>$type</span>
                            </div>
                        </li>
                        ";
                        }
                        }
                        //$data = $this->Interact->get_setting("menutop");
                        }
                        $data = $Options->get("menu");
                        $data = ($data=="") ? array() : json_decode($data, true);
                        __menu($data);
                        @endphp
                        
                    </ol>
                </div>
                <div class="text-right" style="margin-top:25px;">
                    <textarea id="nestable-output" name="data"  style="display:none;"></textarea>
                    <button class="btn btn-info save-menu" type="submit" name="save">Save Menu</button>
                </div>
            </div>
        </form> 
           </div>
        </div>
    </div>
</div>
@include('admin.layout.footer')
<script src="{{ asset("admin-assets/plugins/nestable/nestable.js")}}"></script>
<script>
         $(document).ready(function(){
             var updateOutput = function (e) {
                 var list = e.length ? e : $(e.target),
                         output = list.data('output');
                 if (window.JSON) {
                     output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                 } else {
                     output.val('JSON browser support required for this demo.');
                 }
             };
             // activate Nestable for list 1
             $('#nestable').nestable({
                 group: 1,
                 maxDepth: 3
             }).on('change', updateOutput);

             // output initial serialised data
             updateOutput($('#nestable').data('output', $('#nestable-output')));

             $('#nestable-menu').on('click', function (e) {
                 var target = $(e.target),
                         action = target.data('action');
                 if (action === 'expand-all') {
                     $('.dd').nestable('expandAll');
                 }
                 if (action === 'collapse-all') {
                     $('.dd').nestable('collapseAll');
                 }
             });
             
             function add_to_menu(type,title, slug){
                 var list = $(".main-dd-list");
                 var data = "<li "+
                             "class='dd-item' "+
                             "data-type='"+type+"'"+
                             "data-title='"+title+"'"+ 
                             "data-link='"+slug+"'>"+
                             "<div class='dd-handle'>"+title+""+
                             "<span class='menu-del pull-right' data-id='x'>x</span>"+
                             "<span class='type pull-right'>"+type+"</span>"+
                             "</div>"+
                             "</li>";
                 list.append(data);
                 updateOutput($('#nestable').data('output', $('#nestable-output')));
             }
             
             $(".menu-added").click(function(){
                 var type, id, title, slug;
                 var type = $(this).data("type");
                 if (type=="page" || type=="category"){
                    id = $(this).data("id");
                    title = $(this).data("title");
                    slug = $(this).data("link");
                 }else{
                    title = $("input[name='text']").val();
                    slug = $("input[name='url']").val(); 
                    slug = (slug=="") ? "#" : slug;
                 }
                 if (title==""){
                     alert("Please enter link title");
                 }else{
                    $("input[name='text']").val("");
                    $("input[name='url']").val("");
                    add_to_menu(type, title, slug);
                 }
                 
             });
             
             $(document).on("click",".menu-del",function(){
                var s = window.confirm("Do you want to continue?");
                if (s){
                    $(this).closest(".dd-item").remove();
                    updateOutput($('#nestable').data('output', $('#nestable-output'))); 
                }
             });
             
             $(".save-menu").click(function(){
                var data = $("#nestable-output").val(); 
                var d = JSON.parse(data);
                var r = "Enter menu item.";
                if (Object.keys(d).length > 0){
                    //window.location = "?menu="+check+"&sv=1";
                    return true;
                }
                alert(r);
                return false;
             });
             
         });
    </script>