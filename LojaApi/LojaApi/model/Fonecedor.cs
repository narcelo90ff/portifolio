using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace LojaApi.Models
{
    [Table("Fornecedores")]
    public class Fornecedor
    {
        [Key]
        public int Codigo { get; set; }

        [Required]
        [MaxLength(100)]
        public string Nome { get; set; } = string.Empty;

        [Required]
        [MaxLength(18)]
        public string Cnpj { get; set; } = string.Empty;

        [MaxLength(100)]
        public string Email { get; set; } = string.Empty;

        [MaxLength(20)]
        public string Telefone { get; set; } = string.Empty;
    }
}