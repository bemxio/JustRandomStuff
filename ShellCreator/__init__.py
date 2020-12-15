import shlex

class Shell:
    def __init__(self):
        self.syntaxb = ">>> " # thing that appears before user input
        self.errmsg = "Error:" # error message
        self.__reftb__ = {} # function reference table, don't edit
    def command(self, saveas=None):
        def wrapper(func):
            if not saveas:
                self.__reftb__[func.__name__] = func
            else:
                self.__reftb__[saveas] = func
        return wrapper
    def run(self):
        while True:
            try:
                cmd = shlex.split(input(self.__syntaxb__))
                self.__reftb__[cmd[0]](cmd[1:])
            except Exception as e: # error handling
                print(self.__errmsg__, e)