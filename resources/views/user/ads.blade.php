@extends('user.layout')

@section('user_section')

<div class="page-content">
    <div class="inner-box">
        <div class="dashboard-box">
            <h2 class="dashbord-title">My Ads</h2>
        </div>
        <div class="dashboard-wrapper">
            <nav class="nav-table">
                <ul>
                    <li class="active"><a href="#">All Ads (42)</a></li>
                    <li><a href="#">Published (88)</a></li>
                    <li><a href="#">Featured (12)</a></li>
                    <li><a href="#">Sold (02)</a></li>
                    <li><a href="#">Active (42)</a></li>
                    <li><a href="#">Expired (01)</a></li>
                </ul>
            </nav>
            <table class="table {{-- table-responsive --}} dashboardtable tablemyads">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Precio</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Ajustes</th>
                    </tr>
                </thead>
                <tbody>
                    @if($popular_ads)
                    @foreach($popular_ads as $ad)
                    <tr data-category="active">
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="adone">
                                <label class="custom-control-label" for="adone"></label>
                            </div>
                        </td>
                        <td class="photo"><img class="img-fluid" src="assets/img/product/img1.jpg" alt=""></td>
                        <td data-title="Title">
                            <h3>HP Laptop 6560b core i3 3nd generation</h3>
                            <span>Ad ID: ng3D5hAMHPajQrM</span>
                        </td>
                        <td data-title="Category"><span class="adcategories">Laptops & PCs</span></td>
                        <td data-title="Ad Status"><span class="adstatus adstatusactive">active</span></td>
                        <td data-title="Price">
                            <h3>139$</h3>
                        </td>
                        <td data-title="Action">
                            <div class="btns-actions">
                                <a class="btn-action btn-view" href="#"><i class="lni-eye"></i></a>
                                <a class="btn-action btn-edit" href="#"><i class="lni-pencil"></i></a>
                                <a class="btn-action btn-delete" href="#"><i class="lni-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection