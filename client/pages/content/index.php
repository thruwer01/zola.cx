<?php 
    if (!$contentType) {
        $contentType = 'All content';
        $contentFilter = '';
    }
?>
<input type="hidden" id="typeFilter" value="<?=$contentFilter?>">
<input type="hidden" id="apiToken" value="<?=$userApiToken?>">
<div class="page-wrapper">
    <div class="container-xl">
        <input type="hidden" id="copy">
        <div class="card mt-3">
            <div class="card-header">
                <div class="card-title">
                    Total records: <span id="totalRecords"></span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="<?php if ($contentType !== 'Sports') { echo "col-6"; } else { echo "col-12"; }?>">
                        <input type="text" class="form-control" placeholder="Search.." id="search">
                    </div>
                    <?php if ($contentType !== 'Sports'):?>
                    <div class="col-3">
                        <input type="text" class="form-control" placeholder="Year" id="yearFilter">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" placeholder="IMDB ID" id="imdb">
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                            <th>Date</th>
                            <th>Quality</th>
                            <th>Language</th>
                            <th>ID</th>
                            <?php if ($contentType !== 'Sports'):?>
                                <th>IMDB ID</th>
                            <?php endif;?>
                            <th>View</th>
                            <th>Integration</th>
                        </tr>
                    </thead>
                    <tbody id="contentList">

                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                
                <ul class="pagination m-0 ms-auto" id="btnList">
                    
                </ul>
            </div>
        </div>