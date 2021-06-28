<div class="page-wrapper">
    <div class="container-xl">
        <div class="page-header">
            <h2 class="page-title">Manuals</h2>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <div class="card-title">
                    IFRAME
                </div>
            </div>
            <div class="card-body">
                IFRAME -- manual
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <div class="card-title">
                    REST API - method short
                </div>
            </div>
            <div class="card-body">
                <b>GET </b>request without parameters:
                <a href="https://zola.cx/api/v1/short?api_token=<?=$userApiToken?>" target="_blank">https://zola.cx/api/v1/short?api_token=<?=$userApiToken?></a>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Possible values</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>api_token</td>
                            <td>Required. Your API token</td>
                            <td>string</td>
                            <td>Any string</td>
                        </tr>
                        <tr>
                            <td>id</td>
                            <td>Internal ID of content</td>
                            <td>integer</td>
                            <td>Any ID from content database</td>
                        </tr>
                        <tr>
                            <td>title</td>
                            <td>For search content by title</td>
                            <td>string</td>
                            <td>Any string</td>
                        </tr>
                        <tr>
                            <td>imdb_id</td>
                            <td>For search content by IMDB ID</td>
                            <td>string</td>
                            <td>ID FROM imdb.com</td>
                        </tr>
                        <tr>
                            <td>year</td>
                            <td>For search content by year</td>
                            <td>integer</td>
                            <td>4 numbers of year</td>
                        </tr>
                        <tr>
                            <td>language</td>
                            <td>For search content by language</td>
                            <td>string</td>
                            <td>Any language in ISO 3</td>
                        </tr>
                        <tr>
                            <td>page</td>
                            <td>For pagination by page</td>
                            <td>integer</td>
                            <td>Page number from response</td>
                        </tr>
                        <tr>
                            <td>perPage</td>
                            <td>Determines the number of elements to display per page</td>
                            <td>integer</td>
                            <td>Any number. 100 is the default value</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>