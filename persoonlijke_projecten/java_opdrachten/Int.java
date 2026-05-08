public class Int {
   public static void main(String[] args) {
    /*byte	1 byte	Stores whole numbers from -128 to 127
      short	2 bytes	Stores whole numbers from -32.768 to 32.767
      int	4 bytes	Stores whole numbers from -2.147.483.648 to 2.147.483.647
      long	8 bytes	Stores whole numbers from -9.223.372.036.854.775.808 to 9.223.372.036.854.775.807 end with a L
      float	4 bytes	Stores fractional numbers. Sufficient for storing 6 to 7 decimal digits end with a f
      double	8 bytes	Stores fractional numbers. Sufficient for storing 15 decimal digits en with a d
      boolean	1 bit	Stores true or false values
      char	2 bytes	Stores a single character/letter or ASCII values
    */
    int myInt = 9;
    double myDouble = myInt; // Automatic casting: int to double

    System.out.println(myInt);      // Outputs 9
    System.out.println(myDouble);   // Outputs 9.0
  }
}