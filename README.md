# Food Pantry Manager
## Some Informative Stuff
This is a web application designed primarily to support operations at my local food bank.  If I'm clever enough, this project may be useful for someone else in a similar context.
## Usage
1) Clone into a web server directory, and configure your web server configs.  I'm not going to help you there.  You should know what you're doing.
2) Migrate your data.  Good luck.
3) Create a `.env.local` file to override defaults.
## Contribute
Please!

I'm engineering this app for a specific use case, so there's a good chance something's not set up right or doesn't exist.  Creating an Issue may spark some interesting conversation, but there's nothing like creating a Pull Request to get something done.
### PR Requirements
* Don't commit anything that's specific to your org - that should all live in uncommitted files and databases
* Run all the scripts before committing
  * `composer check`
  * If that fails, `composer fix`, then repeat `composer check`
  * Fix any manual stuff, rinse and repeat
* Comment your code
### Considerations
* Privacy / Security - pantries depend on collection of private data and demographic information; automated tests should consider this where applicable
* Operation models - no two pantries are alike, so avoid defining things too precisely; find the common ground

> Special thanks to [StackEdit](https://stackedit.io/).
