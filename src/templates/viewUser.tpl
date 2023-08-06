{if $user->getId() == $viewUser}

{if $isAdmin}
	<a href = "admin.php">admin</a>
{/if}

<p><a href = "logout.php">Logout</a>.</p>
{/if}
