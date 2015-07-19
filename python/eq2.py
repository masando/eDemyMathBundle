#!/usr/bin/env python
import os
import sys
sympy_dir = os.path.normpath("/home/manuel/sympy")
sys.path.insert(0, sympy_dir)
import sympy
from sympy import *

def main():
    program_name = sys.argv[0]
    arg = sys.argv[1:]
    a = arg[0]
    b = arg[1]
    c = arg[2]
    x = Symbol('x')
    eq =  Integer(a)*x**2+Integer(b)*x+Integer(c)

    print
    pprint(latex(eq))
    print
    
if __name__ == "__main__":
    main()
