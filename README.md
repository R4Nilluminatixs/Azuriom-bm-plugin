A free to use BattleMetrics integration for your Azuriom based website.

**NOTE:**

V0.0.1 (current) is fully constructed based on the game: **RUST** other games **may** or **may not** generate errors on use.

**Installation:**
1. Install the plugin via the marketplace/plugin overview
2. Enabled the plugin in your plugin overview
3. Open the settings page
4. Copy and paste your battlemetrics token.
*  Go to: https://www.battlemetrics.com/developers and sign in
*  Click "New token" next to the title "Personal Access Tokens"
*  Give the token a name and set the correct access rights.
	*  We currently ask for **player data** and **ban data** only in V0.0.1
5. Save the token and you're now done!

**Usage:**

In the current version V0.0.1 we have a few different pages:

*admin:*
- Plugins -> Battlemetrics -> settings
	- This page enables you to add/edit your BattleMetrics access token.
- Plugins -> Battlemetrics -> Ban list
	- This page displays all synchronized bans from BattleMetrics to your system.
- Plugins -> Battlemetrics -> Ban list -> Ban
	- This page displays all information related to the BattleMetrics ban in singular fasion. This includes more data than the list view mentioned above.
- Settings -> Navbar -> add -> "Type: plugin" -> "Wall of shame"
	- This navbar item will add the "wall of shame" page for your users. It will generate a table page with "active" and "relevant" bans.
		- "active" definition: Not expired.
		- "relevant" definition: Has at least a steamID connected.

Want to help me develop this plugin further? Checkout the repo at:
https://github.com/R4Nilluminatixs/Azuriom-bm-plugin
