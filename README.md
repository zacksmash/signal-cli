<p  align="center"><img  src="http://cdn.schematik.cloud/us/image/signal-repo.png"  width="400"></p>

### Local Development Setup

---

1. Have a local WordPress install, called ``wpsignal`` and with the `signal` theme in it.
2. Clone down this ``signal-cli`` repo and run `composer install`, and then run `cp .env.example .env`
3. In the `.env` file, you'll want to put the path to your `signal` theme.
4. When you modify a command and want to test it, from the CLI repo, run `signal app:build` -- Once that finishes, run `signal deploy` and this will copy the latest version of the `signal-cli` to your local `signal` theme.
5. Go to your `signal` theme root and run your CLI command from there.
6. If all works, you can commit `signal-cli` and remove any generated files and modifications from the `signal` theme.
