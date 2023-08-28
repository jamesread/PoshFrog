<br /><br />
</div> <!-- page !-->

<footer>
	{if $isPopup}
	<a href = "javascript:window.close()">Close window</a>
	<br /><br />
	{else}
	{popup('Powered by pFrog.', 'help.php?topic=pFrog')}
	Version <strong>{$version}</strong>. <br />
	{/if}
</footer>

</body>

</html>
