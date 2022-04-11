{extends file="main.tpl"}

{block name=content}

<div class="pure-menu pure-menu-horizontal bottom-margin">
	<a href="{$conf->action_url}logout"  class="pure-menu-heading pure-menu-link">wyloguj</a>
	<span style="float:right;">użytkownik: {$user->login}, rola: {$user->role}</span>
</div>

<form action="{$conf->action_url}calcCompute" method="post" class="pure-form pure-form-aligned bottom-margin">
	<legend>Kalkulator</legend>
	<fieldset>
		<label for="kwota">Kwota</label>
		<input id="kwota" type="text" placeholder="Kwota" name="kwota" value="{$form->kwota}">
		<label for="okres">Okres</label>
		<input id="okres" type="text" placeholder="Okres" name="okres" value="{$form->okres}">
		<label for="procent">Oprocentowanie</label>
		<input id="procent" type="text" placeholder="Oprocentowanie" name="procent" value="{$form->procent}">
	</fieldset>
	<button type="submit" class="pure-button pure-button-primary">Oblicz</button>

</form>

{include file='messages.tpl'}

{if isset($res->result)}
<div class="messages info">
	Wynik: {$res->result}
</div>
{/if}

{/block}