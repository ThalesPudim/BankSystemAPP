import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class ConnectionManager {
    private static final String URL = "jdbc:mysql://localhost:3306/hringbank?useSSL=false&serverTimezone=UTC&user=root";
    private static final String DRIVER_CLASS = "com.mysql.cj.jdbc.Driver";

    static {
        try {
            // Carrega a classe do driver MySQL
            Class.forName(DRIVER_CLASS);
        } catch (ClassNotFoundException e) {
            throw new RuntimeException("Não foi possível carregar o driver JDBC", e);
        }
    }

    public static Connection getConnection() throws SQLException {
        return DriverManager.getConnection(URL);
    }

    public static void main(String[] args) {
        try {
            // Testa a conexão com o banco de dados
            Connection connection = getConnection();
            System.out.println("Conexão bem-sucedida!");
            // Aqui você pode adicionar mais lógica para manipular o banco de dados
            // Lembre-se de fechar a conexão quando terminar de usá-la
            connection.close();
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Falha na conexão com o banco de dados.");
        }
    }
}