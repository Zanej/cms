{$idPage = "task"}
{if $type == "daily"}
	{$bodyClass = "daily"}
{/if}
{extends file="./default.tpl"}
{block name="right_side"}
	{if $type == "daily"}

		{include file="./daily.tpl"}
	{/if}
{/block}