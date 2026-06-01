package interfaces;
import java.util.List;

public interface Pesquisavel<T> {
    T buscarPorCodigo(int codigo);
    List<T> buscarPorNome(String nome);
}
