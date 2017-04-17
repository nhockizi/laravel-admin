<link rel="stylesheet" href="{{ asset("/packages/admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset("/packages/admin/font-awesome/css/font-awesome.min.css") }}">
{!! Admin::css() !!}
<link rel="stylesheet" href="{{ asset("/packages/admin/nestable/nestable.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/toastr/build/toastr.min.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/bootstrap3-editable/css/bootstrap-editable.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/google-fonts/fonts.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/AdminLTE/dist/css/AdminLTE.min.css") }}">
<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset ("/packages/admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
<script src="{{ asset ("/packages/admin/js/jquery-ui.js") }}"></script>
<script src="{{ asset ("/packages/admin/AdminLTE/bootstrap/js/bootstrap.min.js") }}"></script>
<script src="{{ asset ("/packages/admin/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
<script src="{{ asset ("/packages/admin/jstree/dist/jstree.min.js") }}"></script>
<link rel="stylesheet" href="{{ asset("/packages/admin/css/jquery-ui.css") }}" />
<style>
#container { min-width:100%; margin:0px auto 0 auto; background:white; border-radius:0px; padding:0px; overflow:hidden; }
#tree { float:left; min-width:100%; border-right:1px solid silver; overflow:auto; padding:0px 0;height: 90% !important; }
#data textarea { margin:0; padding:0; height:100%; width:100%; border:0; background:white; display:block; line-height:18px; resize:none; }
#data, #code { font: normal normal normal 12px/18px 'Consolas', monospace !important; }
#tree .folder { background:url('{{asset('packages/admin/jstree/file_sprite.png')}}') right bottom no-repeat; }
#tree .file { background:url('{{asset('packages/admin/jstree/file_sprite.png')}}') 0 0 no-repeat; }
#tree .file-pdf { background-position: -32px 0 }
#tree .file-as { background-position: -36px 0 }
#tree .file-c { background-position: -72px -0px }
#tree .file-iso { background-position: -108px -0px }
#tree .file-htm, #tree .file-html, #tree .file-xml, #tree .file-xsl { background-position: -126px -0px }
#tree .file-cf { background-position: -162px -0px }
#tree .file-cpp { background-position: -216px -0px }
#tree .file-cs { background-position: -236px -0px }
#tree .file-sql { background-position: -272px -0px }
#tree .file-xls, #tree .file-xlsx { background-position: -362px -0px }
#tree .file-h { background-position: -488px -0px }
#tree .file-crt, #tree .file-pem, #tree .file-cer { background-position: -452px -18px }
#tree .file-php { background-position: -108px -18px }
#tree .file-jpg, #tree .file-jpeg, #tree .file-png, #tree .file-gif, #tree .file-bmp { background-position: -126px -18px }
#tree .file-ppt, #tree .file-pptx { background-position: -144px -18px }
#tree .file-rb { background-position: -180px -18px }
#tree .file-text, #tree .file-txt, #tree .file-md, #tree .file-log, #tree .file-htaccess { background-position: -254px -18px }
#tree .file-doc, #tree .file-docx { background-position: -362px -18px }
#tree .file-zip, #tree .file-gz, #tree .file-tar, #tree .file-rar { background-position: -416px -18px }
#tree .file-js { background-position: -434px -18px }
#tree .file-css { background-position: -144px -0px }
#tree .file-fla { background-position: -398px -0px }
.CodeMirror{
	height: 80% !important;
}
.ui-closable-tab{
	position: absolute;
    top: 0;
    right: 0;
    cursor: pointer;
}
</style>
<link rel="stylesheet" href="{{ asset("/packages/admin/jstree/dist/themes/default/style.min.css") }}">

<div class="col-xs-3">
	<div class="row">
		<div id="tree"></div>
	</div>
</div>
<div class="col-xs-9">
	<div class="row">
		<div id="form-detail" class="nav-tabs-custom">
			<ul class="nav nav-tabs" style="height: 45px;">
			</ul>
			<div class="tab-content">
			</div>
		</div>
	</div>
</div>
<script>
$(function () {
	$('#tree')
		.jstree({
			'core' : {
				'data' : {
					'url' : '{!! route('folder.data') !!}',
					'data' : function (node) {
						return { 'id' : node.id };
					},
					'error': function (data) {
$('#jstree').html('<p>We had an error...</p>');
}
				},
				'check_callback' : function(o, n, p, i, m) {
					if(m && m.dnd && m.pos !== 'i') { return false; }
					if(o === "move_node" || o === "copy_node") {
						if(this.get_node(n).parent === this.get_node(p).id) { return false; }
					}
					return true;
				},
				'force_text' : true,
				'themes' : {
					'responsive' : false,
					'variant' : 'small',
					'stripes' : true
				}
			},
			'sort' : function(a, b) {
				return this.get_type(a) === this.get_type(b) ? (this.get_text(a) > this.get_text(b) ? 1 : -1) : (this.get_type(a) >= this.get_type(b) ? 1 : -1);
			},
			'contextmenu' : {
				'items' : function(node) {
					var tmp = $.jstree.defaults.contextmenu.items();
					delete tmp.create.action;
					tmp.create.label = "New";
					tmp.create.submenu = {
						"create_folder" : {
									"separator_after"	: true,
															"label"				: "Folder",
													"action"			: function (data) {
								var inst = $.jstree.reference(data.reference),
									obj = inst.get_node(data.reference);
								inst.create_node(obj, { type : "default" }, "last", function (new_node) {
									setTimeout(function () { inst.edit(new_node); },0);
								});
							}
						},
						"create_file" : {
															"label"				: "File",
													"action"			: function (data) {
								var inst = $.jstree.reference(data.reference),
									obj = inst.get_node(data.reference);
								inst.create_node(obj, { type : "file" }, "last", function (new_node) {
									setTimeout(function () { inst.edit(new_node); },0);
								});
							}
						}
					};
					if(this.get_type(node) === "file") {
						delete tmp.create;
					}
					return tmp;
				}
			},
			'types' : {
				'default' : { 'icon' : 'folder' },
				'file' : { 'valid_children' : [], 'icon' : 'file' }
			},
			'unique' : {
				'duplicate' : function (name, counter) {
					return name + ' ' + counter;
				}
			},
			'plugins' : ['state','dnd','sort','types','contextmenu','unique']
		})
		.on('delete_node.jstree', function (e, data) {
			$.get('{!! route('folder.data') !!}?operation=delete_node', { 'id' : data.node.id })
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on('create_node.jstree', function (e, data) {
			$.get('{!! route('folder.data') !!}?operation=create_node', { 'type' : data.node.type, 'id' : data.node.parent, 'text' : data.node.text })
				.done(function (d) {
					data.instance.set_id(data.node, d.id);
				})
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on('rename_node.jstree', function (e, data) {
			$.get('{!! route('folder.data') !!}?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
				.done(function (d) {
					data.instance.set_id(data.node, d.id);
				})
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on('move_node.jstree', function (e, data) {
			$.get('{!! route('folder.data') !!}?operation=move_node', { 'id' : data.node.id, 'parent' : data.parent })
				.done(function (d) {
					data.instance.load_node(data.parent);
				})
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on('copy_node.jstree', function (e, data) {
			$.get('{!! route('folder.data') !!}?operation=copy_node', { 'id' : data.original.id, 'parent' : data.parent })
				.done(function (d) {
					data.instance.load_node(data.parent);
				})
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on('changed.jstree', function (e, data) {
			if(data && data.selected && data.selected.length) {
				$.get('{!! route('developer.load-content-file') !!}', { 'id' : data.node.id})
					.done(function (d) {
						if(d && typeof d.type !== 'undefined') {
							switch(d.type) {
								case 'png':
								case 'jpg':
								case 'jpeg':
								case 'bmp':
								case 'gif':
								case 'folder':
									break;
								default:
									$("#form-detail").find('li').removeClass('active');
									$("#form-detail .tab-content").find('.tab-pane').removeClass('active');
									$("#form-detail ul").append('<li class="active"><a href="#tab_'+d.id+'" data-toggle="tab" aria-expanded="false">'+d.name+'</a><span class="ui-icon ui-icon-circle-close ui-closable-tab"></span></li>');
									$("#form-detail .tab-content").append('<div class="tab-pane active" id="tab_'+d.id+'">'+d.content+'</div>');
									break;
							}

						}
						// $("#form-detail").html(d);
					})
					.fail(function () {
						$("#form-detail").html('');
					});
			}
		});
});
</script>
<script src="{{ asset ("/packages/admin/codemirror/lib/codemirror.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/edit/matchbrackets.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/htmlmixed/htmlmixed.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/xml/xml.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/markdown/markdown.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/javascript/javascript.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/css/css.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/clike/clike.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/php/php.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/hint/show-hint.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/hint/css-hint.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/hint/html-hint.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/hint/javascript-hint.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/clike/clike.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/display/fullscreen.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/keymap/sublime.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/search/search.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/search/searchcursor.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/search/jump-to-line.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/dialog/dialog.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/scroll/simplescrollbars.js") }}"></script>
<link rel="stylesheet" href="{{ asset("/packages/admin/codemirror/lib/codemirror.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/codemirror/addon/hint/show-hint.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/codemirror/addon/display/fullscreen.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/codemirror/addon/dialog/dialog.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/codemirror/addon/scroll/simplescrollbars.css") }}">
