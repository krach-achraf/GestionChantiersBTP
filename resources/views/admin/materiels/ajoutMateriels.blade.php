@extends('admin.layouts.menu')
@section('content')
    <div class="card">
        <div class="card-header " style="background-color: #0f4c75;color: white">
            L'ajout des materiels
        </div>

        <div class="card-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <form action="{{route('materiels.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Libellé</th>
                            <th scope="col">Date accusée</th>
                            <th scope="col">Photo du matériel </th>
                            <th scope="col">Fournisseur</th>
                            <th scope="col"><a href="javascript:" class="btn btn-primary addRow fa fa-plus"></a></th>
                        </tr>
                        </thead>
                        <tbody class="resultbody">
                            <tr>
                                <td>
                                    <input name="libelle[]" type="text" class="form-control" value="{{ old('libelle.0')}}">
                                </td>
                                <td>
                                    <input name="dateAccuse[]" type="date"  class="form-control" value="{{ old('dateAccuse.0')}}">
                                </td>
                                <td>
                                    <input name="photo[]" type="file"  class="form-control" value="{{ old('photo.0')}}">
                                </td>
                                <td>
                                    <select name="fournisseur[]" class="form-control">
                                        <option disabled="disabled" selected>Choisissez le fournisseur :</option>
                                        @foreach($fournisseurs as $fournisseur)
                                            <option value="{{$fournisseur->id}}" {{ old('fournisseur.0', $fournisseur->nom . ' ' .$fournisseur->prenom) == $fournisseur->id ? 'selected' : '' }}>{{$fournisseur->nom}} {{$fournisseur->prenom}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td scope="col"><a href="javascript:" class="btn btn-dark deleteRow fa fa-minus"></a></td>
                            </tr>
                        @if(old('libelle'))
                            @for( $i =1; $i < count(old('libelle')); $i++)
                                <tr>
                                <td>
                                    <input name="libelle[]" type="text" class="form-control" value="{{ old('libelle.'.$i)}}">
                                </td>
                                <td>
                                    <input name="dateAccuse[]" type="date"  class="form-control" value="{{ old('dateAccuse.'.$i)}}">
                                </td>
                                <td>
                                    <input name="photo[]" type="file"  class="form-control" value="{{ old('photo.'.$i)}}">
                                </td>
                                <td>
                                    <select name="fournisseur[]" class="form-control">
                                        <option disabled="disabled" selected>Choisissez le fourniseur :</option>
                                        @foreach($fournisseurs as $fournisseur)
                                            <option value="{{$fournisseur->id}}" {{ old('fournisseur.'.$i, $fournisseur->nom . ' ' .$fournisseur->prenom) == $fournisseur->id ? 'selected' : '' }}>{{$fournisseur->nom}} {{$fournisseur->prenom}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td scope="col"><a href="javascript:" class="btn btn-danger deleteRow fa fa-minus"></a></td>
                            </tr>
                            @endfor
                        @endif
                        </tbody>
                    </table>
                <button class="btn btn-outline-dark col-md-4 offset-md-4">Enregistrer</button>
            </form>
        </div>

    </div>
@endsection
