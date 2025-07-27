<?php 
use Carbon\Carbon;
?>

@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - crée une note")
@section("content")

<div class="container mt-5">
    <form action="#" method="post">
        @csrf
        <div class="form-group">
            <label for="note" class="fs-5">Ajout d'une Note: {{ $puit[0]->Name }}</label>
            <select name="info_classic"  class="form-control mt-2" id="info">
                <optgroup label="Berg">
                    <option selected value="Changement de berg">Changement de berg</option>
                    <option value="Refaire étanchéité du puit">Refaire étanchéité du puit</option>
                    <option value="Mauvaise étanchéité du brerg">Mauvaise étanchéité du berg</option>
                    <option value="Resserrage du berg">Resserrage du berg</option>
                </optgroup>
                <optgroup label="Vanne">
                    <option value="Changement de vanne">Changement de vanne</option>
                    <option selected ="Mauvaise étanchéité de la vanne">Mauvaise étanchéité de la vanne</option>
                </optgroup>
                <optgroup label="Prise d'échantillon">
                    <option value="Changer la prise d'échantillon"> Changer la prise d'échantillon </option>
                    <option value="Changer le bouchon sur la prise d'echantillon">Changer le bouchon sur la prise d'echantillon</option>
                    <option value="Mauvaise étanchéité de la prise d'échantillon">Mauvaise étanchéité de la prise d'échantillon</option>
                    <option value="Mauvais diamètre sur la prise échantillon">Mauvais diamètre sur la prise échantillon</option>
                    <option value="Manque prise échantillon">Manque prise échantillon</option>
                </optgroup>
                <optgroup label="Action Groupée">
                    <option value="Changement de berg + révision de la vanne">Changement de berg + révision de la vanne</option>
                    <option value="Changement de berg + révision de la vanne + Manque prise échantillon">Changement de berg + révision de la vanne + Manque prise échantillon</option>
                </optgroup>
                <optgroup label="Modification du reseau">
                    <option value="Demande de manchon de dilatation">Demande de manchon de dilatation</option>
                    <option value="Demande de vanne">Demande de vanne</option>
                    <option value="Demande de prise d'échantillon">Demande de prise d'échantillon</option>
                    <option value="Demande de vanne + prise d'échantillon">Demande de vanne + prise d'échantillon</option>
                    <option value="Demande de vanne + prise d'échantillon + manchon de dilatation">Demande de vanne + prise d'échantillon + manchon de dilatation</option>
                    <option value="Demande d'une purges amont">Demande d'une purges Amont</option>
                    <option value="Demande d'une purges aval">Demande d'une purges Aval</option>
                    <option value="Demande d'un rajout de tyaux et modification + berg">Demande d'un rajout de tyaux et modification + berg</option>
                </optgroup>
                <optgroup label="Etat du puit">
                    <option value="Sous vide">Sous vide</option>
                    <option value="Puit soutirer par le massif">Puit soutirer par le massif</option>
                </optgroup>

                <option value="autre" id="autre">Autre</option>
                <textarea class="form-control mt-2" name="info" id="text" cols="30" rows="10"></textarea>
            </select>
        </div>
        <input type="hidden" name="puits_id" value="{{ $puit[0]->id }}">
        <input type="hidden" name="name" value="{{ $puit[0]->Name }}">
        <button type="submit" class="btn btn-primary mt-2">Ajouter</button>
    </form>
</div>


<script>
    document.getElementById("text").style.display = "none";
    // faire afficher le textarea si l'utilisateur dans la liste déroulante id info choisi autre
    document.getElementById("info").addEventListener("change", function(){
        if(document.getElementById("info").value == "autre"){
            document.getElementById("text").style.display = "block";
        }else{
            document.getElementById("text").style.display = "none";
        }
    });
</script>

@endsection

