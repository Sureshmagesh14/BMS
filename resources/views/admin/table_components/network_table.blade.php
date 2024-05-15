<div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
    <div class="btn-group mr-2" role="group" aria-label="Second group">
        <a href="#!" data-url="{{ route('networks.create') }}" data-size="xl" data-ajax-popup="true"
            class="btn btn-primary" data-bs-original-title="{{ __('Create Networks') }}" class="btn btn-primary"
            data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
            Create Networks
        </a>
    </div>
    <div class="btn-group network_table hided_option" role="group" aria-label="Third group" style="display: none;">
        <div class="btn-group dropdown-filter">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                    aria-labelledby="delete" role="presentation" class="fill-current text-80">
                    <path fill-rule="nonzero"
                        d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z">
                    </path>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6" class="ml-2">
                    <path fill="var(--90)"
                        d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                    </path>
                </svg>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">
                    <a class="btn btn-danger network_table delete_all" class="btn btn-primary">
                        Delete Selected All
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<h4 class="card-title"> </h4>
<p class="card-title-desc"></p>

<table id="network_table" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>
                <input type="checkbox" class="select_all" id="inlineForm-customCheck">
            </th>
            <th>#</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
