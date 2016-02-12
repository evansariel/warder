{{-- Part of phoenix project. --}}

<a type="button" class="waves-effect waves-light btn btn-success" href="{{ $router->html('user', array('new' => true)) }}">
    <span class="glyphicon glyphicon-plus fa fa-plus"></span>
    @translate('phoenix.toolbar.new')
</a>

{{--<button type="button" class="waves-effect btn btn-default" onclick="Phoenix.Grid.hasChecked();Phoenix.post();">--}}
    {{--<span class="glyphicon glyphicon-duplicate fa fa-copy text-info"></span>--}}
    {{--@translate('phoenix.toolbar.duplicate')--}}
{{--</button>--}}

{{--<button type="button" class="waves-effect btn btn-default" onclick="Phoenix.Grid.hasChecked();Phoenix.patch(null, {task: 'publish'});">--}}
    {{--<span class="glyphicon glyphicon-ok fa fa-check text-success"></span>--}}
    {{--@translate('phoenix.toolbar.publish')--}}
{{--</button>--}}

{{--<button type="button" class="waves-effect btn btn-default" onclick="Phoenix.Grid.hasChecked();Phoenix.patch(null, {task: 'unpublish'});">--}}
    {{--<span class="glyphicon glyphicon-remove fa fa-remove text-danger"></span>--}}
    {{--@translate('phoenix.toolbar.unpublish')--}}
{{--</button>--}}

{{--<button type="button" class="waves-effect btn btn-default" data-toggle="modal" data-target="#batch-modal" onclick="Phoenix.Grid.hasChecked(null, event);">--}}
    {{--<span class="glyphicon glyphicon-modal-window fa fa-sliders"></span>--}}
    {{--@translate('phoenix.toolbar.batch')--}}
{{--</button>--}}

<button type="button" class="waves-effect btn btn-default" onclick="Phoenix.Grid.hasChecked().deleteList();">
    <span class="glyphicon glyphicon-trash fa fa-trash"></span>
    @translate('phoenix.toolbar.delete')
</button>
