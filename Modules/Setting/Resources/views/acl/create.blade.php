@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('acls.store') }}" method="post" class="card">
    @csrf
    <div class="card-header">
        <div class="row">
            <div class="col-sm-12 col-md">
                <h1 class="h2 mb-0">{{__('New Acl')}}</h1>
            </div>
            <div class="col-sm-12 col-md-auto pt-2">
                <button type="submit" class="btn btn-sm btn-danger">{{ __("Save") }}</button>
                <a class="btn btn-sm btn-primary" href="{{ route('acls.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <?php foreach ($roles as $role): ?>
                        <th><?php echo $role->name; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($resources as $resource): ?>
                <tr>
                    <td colspan="<?php echo count($roles) + 1 ?>"><?php echo $resource->name;?></td>
                </tr>
                <?php foreach ($resource->actions as $action): ?>
                    <tr>
                        <td><?php echo $action->name; ?></td>
                        <?php foreach ($roles as $role): ?>
                            <td>
                                <?php
                                    $hasAccess = "";
                                    if($role->acls()->where(
                                            [
                                                'action_id' => $action->id,
                                                'resource_id' => $resource->id
                                            ]
                                    )->count() > 0) {
                                        $hasAccess = "checked";
                                    }
                                    echo "<input type='checkbox' name='acl[resource][".$resource->id."][action][".$action->id."][role][".$role->id."]' $hasAccess>";
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</form>
@endsection
