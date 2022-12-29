package com.example.inventorymanager

import android.graphics.drawable.ColorDrawable
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import com.example.inventorymanager.databinding.FragmentCategoriesBinding

class CategoriesFragment : Fragment() {

    private var _binding: FragmentCategoriesBinding? = null

    private val binding get() = _binding!!

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        _binding = FragmentCategoriesBinding.inflate(inflater, container, false)
        return binding.root
    }


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        val categoryList: MutableList<Category> = ArrayList()

        (activity as AppCompatActivity?)!!.supportActionBar!!.setBackgroundDrawable(
            ColorDrawable(
                resources.getColor(R.color.green_element, binding.root.context.theme)
            )
        )

        categoryList.add(
            Category(
                1,
                resources.getString(R.string.img_cat_ordenadores),
                resources.getString(R.string.cat_ordenadores),
                resources.getString(R.string.desc_cat_ordenadores)
            )
        )
        categoryList.add(
            Category(
                2,
                resources.getString(R.string.img_cat_smartphones),
                resources.getString(R.string.cat_smartphones),
                resources.getString(R.string.desc_cat_smartphones)
            )
        )
        categoryList.add(
            Category(
                3,
                resources.getString(R.string.img_cat_televisores),
                resources.getString(R.string.cat_televisores),
                resources.getString(R.string.desc_cat_televisores)
            )
        )
        categoryList.add(
            Category(
                4,
                resources.getString(R.string.img_cat_audio),
                resources.getString(R.string.cat_audio),
                resources.getString(R.string.desc_cat_audio)
            )
        )
        categoryList.add(
            Category(
                5,
                resources.getString(R.string.img_cat_perifericos),
                resources.getString(R.string.cat_perifericos),
                resources.getString(R.string.desc_cat_perifericos)
            )
        )
        categoryList.add(
            Category(
                6,
                resources.getString(R.string.img_cat_componentes),
                resources.getString(R.string.cat_componentes),
                resources.getString(R.string.desc_cat_componentes)
            )
        )
        categoryList.add(
            Category(
                7,
                resources.getString(R.string.img_cat_electrodomesticos),
                resources.getString(R.string.cat_electrodomesticos),
                resources.getString(R.string.desc_cat_electrodomesticos)
            )
        )
        categoryList.add(
            Category(
                8,
                resources.getString(R.string.img_cat_consolas),
                resources.getString(R.string.cat_consolas),
                resources.getString(R.string.desc_cat_consolas)
            )
        )
        categoryList.add(
            Category(
                9,
                resources.getString(R.string.img_cat_tablets),
                resources.getString(R.string.cat_tablets),
                resources.getString(R.string.desc_cat_tablets)
            )
        )

        binding.listCategories.apply { adapter = AdapterCategory(categoryList) }

    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }

}