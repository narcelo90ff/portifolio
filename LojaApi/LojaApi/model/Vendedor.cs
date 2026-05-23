using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace LojaApi.Models
{
    [Table("Vendedores")]
    public class Vendedor
    {
        [Key]
        public int Codigo { get; set; }

        [Required]
        [MaxLength(100)]
        public string Nome { get; set; } = string.Empty;

        [MaxLength(100)]
        public string Email { get; set; } = string.Empty;

        [MaxLength(20)]
        public string Telefone { get; set; } = string.Empty;

        [Column(TypeName = "decimal(18,2)")]
        public decimal Salario { get; set; }
    }
}